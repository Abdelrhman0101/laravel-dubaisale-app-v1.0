<?php

/**
 * اختبار مبسط لأمان حقول latitude و longitude
 * 
 * هذا الـ Script يفحص الملفات مباشرة بدون تحميل Laravel
 */

echo "🔍 بدء اختبار أمان حقول latitude و longitude...\n\n";

class SimpleSecurityTest
{
    private $vulnerabilities = [];
    private $recommendations = [];
    private $results = [];

    public function runTests()
    {
        $this->testUserModel();
        $this->testAdModels();
        $this->testControllers();
        $this->testMigrations();
        $this->generateReport();
    }

    /**
     * فحص نموذج User
     */
    private function testUserModel()
    {
        echo "👤 فحص نموذج User...\n";
        
        $userModelPath = __DIR__ . '/app/Models/User.php';
        if (!file_exists($userModelPath)) {
            echo "❌ ملف User.php غير موجود\n";
            return;
        }
        
        $content = file_get_contents($userModelPath);
        
        // البحث عن fillable array
        preg_match('/protected\s+\$fillable\s*=\s*\[(.*?)\];/s', $content, $fillableMatches);
        $fillableContent = $fillableMatches[1] ?? '';
        
        // فحص إذا كانت latitude/longitude في fillable
        $latInFillable = strpos($fillableContent, "'latitude'") !== false || strpos($fillableContent, '"latitude"') !== false;
        $lngInFillable = strpos($fillableContent, "'longitude'") !== false || strpos($fillableContent, '"longitude"') !== false;
        
        // البحث عن guarded array
        preg_match('/protected\s+\$guarded\s*=\s*\[(.*?)\];/s', $content, $guardedMatches);
        $guardedContent = $guardedMatches[1] ?? '';
        
        $this->results['user_model'] = [
            'latitude_fillable' => $latInFillable,
            'longitude_fillable' => $lngInFillable,
            'fillable_content' => trim($fillableContent),
            'guarded_content' => trim($guardedContent)
        ];
        
        if ($latInFillable && $lngInFillable) {
            $this->vulnerabilities[] = "🚨 خطر أمني عالي: حقول latitude و longitude قابلة للتعديل المباشر في نموذج User";
            $this->recommendations[] = "🔧 يجب إزالة latitude/longitude من fillable أو إضافة validation قوي";
        }
        
        echo "✅ فحص نموذج User مكتمل\n";
    }

    /**
     * فحص نماذج الإعلانات
     */
    private function testAdModels()
    {
        echo "📢 فحص نماذج الإعلانات...\n";
        
        $models = [
            'CarRentAd' => __DIR__ . '/app/Models/CarRentAd.php',
            'RealEstateAd' => __DIR__ . '/app/Models/RealEstateAd.php',
            'CarSalesAd' => __DIR__ . '/app/Models/CarSalesAd.php'
        ];
        
        foreach ($models as $modelName => $path) {
            if (!file_exists($path)) {
                continue;
            }
            
            $content = file_get_contents($path);
            
            // فحص guarded
            $usesEmptyGuarded = strpos($content, 'protected $guarded = [];') !== false;
            
            // فحص fillable
            preg_match('/protected\s+\$fillable\s*=\s*\[(.*?)\];/s', $content, $fillableMatches);
            $fillableContent = $fillableMatches[1] ?? '';
            
            $this->results['ad_models'][$modelName] = [
                'uses_empty_guarded' => $usesEmptyGuarded,
                'fillable_content' => trim($fillableContent)
            ];
            
            if ($usesEmptyGuarded) {
                $this->vulnerabilities[] = "⚠️ $modelName يستخدم guarded = [] مما يعني أن جميع الحقول قابلة للتعديل بما في ذلك latitude/longitude";
                $this->recommendations[] = "🔧 يُنصح بتحديد fillable بدلاً من استخدام guarded فارغ في $modelName";
            }
        }
        
        echo "✅ فحص نماذج الإعلانات مكتمل\n";
    }

    /**
     * فحص Controllers
     */
    private function testControllers()
    {
        echo "🎮 فحص Controllers...\n";
        
        $controllers = [
            'ProfileController' => __DIR__ . '/app/Http/Controllers/Api/ProfileController.php',
            'AdminUserController' => __DIR__ . '/app/Http/Controllers/Api/Admin/UserController.php',
            'CarRentAdController' => __DIR__ . '/app/Http/Controllers/Api/CarRentAdController.php'
        ];
        
        foreach ($controllers as $controllerName => $path) {
            if (!file_exists($path)) {
                continue;
            }
            
            $content = file_get_contents($path);
            
            // البحث عن validation لـ latitude/longitude
            $hasLatValidation = preg_match("/['\"]latitude['\"].*?=>/", $content);
            $hasLngValidation = preg_match("/['\"]longitude['\"].*?=>/", $content);
            
            // البحث عن setAddress method
            $hasSetAddressMethod = strpos($content, 'setAddress') !== false;
            
            // البحث عن validation rules
            $hasValidationRules = strpos($content, 'between:-90,90') !== false && strpos($content, 'between:-180,180') !== false;
            
            $this->results['controllers'][$controllerName] = [
                'has_latitude_validation' => (bool)$hasLatValidation,
                'has_longitude_validation' => (bool)$hasLngValidation,
                'has_set_address_method' => $hasSetAddressMethod,
                'has_proper_validation_rules' => $hasValidationRules
            ];
            
            if ($controllerName === 'ProfileController' && !$hasLatValidation && !$hasLngValidation) {
                $this->vulnerabilities[] = "⚠️ ProfileController لا يحتوي على validation لحقول latitude/longitude";
                $this->recommendations[] = "🔧 يجب إضافة validation لحقول latitude/longitude في ProfileController";
            }
            
            if ($hasSetAddressMethod && $hasValidationRules) {
                $this->recommendations[] = "✅ $controllerName يحتوي على validation مناسب لحقول الموقع";
            }
        }
        
        echo "✅ فحص Controllers مكتمل\n";
    }

    /**
     * فحص ملفات Migration
     */
    private function testMigrations()
    {
        echo "🗄️ فحص ملفات Migration...\n";
        
        $migrationDir = __DIR__ . '/database/migrations';
        if (!is_dir($migrationDir)) {
            echo "❌ مجلد migrations غير موجود\n";
            return;
        }
        
        $migrationFiles = glob($migrationDir . '/*.php');
        $tablesWithLatLng = [];
        
        foreach ($migrationFiles as $file) {
            $content = file_get_contents($file);
            $filename = basename($file);
            
            // البحث عن إضافة latitude/longitude
            if (strpos($content, 'latitude') !== false && strpos($content, 'longitude') !== false) {
                $tablesWithLatLng[] = $filename;
            }
        }
        
        $this->results['migrations'] = [
            'files_with_lat_lng' => $tablesWithLatLng,
            'total_migration_files' => count($migrationFiles)
        ];
        
        if (!empty($tablesWithLatLng)) {
            $this->recommendations[] = "📊 تم العثور على " . count($tablesWithLatLng) . " ملف migration يحتوي على حقول latitude/longitude";
        }
        
        echo "✅ فحص ملفات Migration مكتمل\n";
    }

    /**
     * إنتاج التقرير النهائي
     */
    private function generateReport()
    {
        echo "\n" . str_repeat("=", 80) . "\n";
        echo "📋 التقرير النهائي لأمان latitude/longitude\n";
        echo str_repeat("=", 80) . "\n\n";
        
        // عرض الثغرات الأمنية
        if (!empty($this->vulnerabilities)) {
            echo "🚨 الثغرات الأمنية المكتشفة (" . count($this->vulnerabilities) . "):\n";
            foreach ($this->vulnerabilities as $i => $vulnerability) {
                echo "  " . ($i + 1) . ". $vulnerability\n";
            }
            echo "\n";
        } else {
            echo "✅ لم يتم اكتشاف ثغرات أمنية واضحة\n\n";
        }
        
        // عرض التوصيات
        if (!empty($this->recommendations)) {
            echo "💡 التوصيات (" . count($this->recommendations) . "):\n";
            foreach ($this->recommendations as $i => $recommendation) {
                echo "  " . ($i + 1) . ". $recommendation\n";
            }
            echo "\n";
        }
        
        // تقييم عام للمخاطر
        $riskLevel = count($this->vulnerabilities);
        echo "📊 تقييم المخاطر:\n";
        if ($riskLevel == 0) {
            echo "🟢 مستوى المخاطر: منخفض - النظام يبدو آمناً نسبياً\n";
        } elseif ($riskLevel <= 2) {
            echo "🟡 مستوى المخاطر: متوسط - يوجد بعض المخاطر التي تحتاج انتباه\n";
        } else {
            echo "🔴 مستوى المخاطر: عالي - يوجد مخاطر أمنية تحتاج إصلاح فوري\n";
        }
        
        echo "\n📝 ملخص النتائج:\n";
        
        // عرض نتائج User Model
        if (isset($this->results['user_model'])) {
            $userModel = $this->results['user_model'];
            echo "👤 نموذج User:\n";
            echo "   - latitude في fillable: " . ($userModel['latitude_fillable'] ? "نعم ⚠️" : "لا ✅") . "\n";
            echo "   - longitude في fillable: " . ($userModel['longitude_fillable'] ? "نعم ⚠️" : "لا ✅") . "\n";
        }
        
        // عرض نتائج Ad Models
        if (isset($this->results['ad_models'])) {
            echo "📢 نماذج الإعلانات:\n";
            foreach ($this->results['ad_models'] as $modelName => $data) {
                echo "   - $modelName: " . ($data['uses_empty_guarded'] ? "يستخدم guarded فارغ ⚠️" : "محمي ✅") . "\n";
            }
        }
        
        // عرض نتائج Controllers
        if (isset($this->results['controllers'])) {
            echo "🎮 Controllers:\n";
            foreach ($this->results['controllers'] as $controllerName => $data) {
                $status = ($data['has_latitude_validation'] || $data['has_longitude_validation'] || $data['has_proper_validation_rules']) ? "✅" : "⚠️";
                echo "   - $controllerName: $status\n";
            }
        }
        
        // عرض نتائج Migrations
        if (isset($this->results['migrations'])) {
            echo "🗄️ Migrations:\n";
            echo "   - ملفات تحتوي على lat/lng: " . count($this->results['migrations']['files_with_lat_lng']) . "\n";
        }
        
        echo "\n🔍 تحليل مفصل:\n";
        echo "================\n";
        
        echo "1. حماية Mass Assignment:\n";
        if (isset($this->results['user_model'])) {
            if ($this->results['user_model']['latitude_fillable'] && $this->results['user_model']['longitude_fillable']) {
                echo "   ❌ المستخدمون يمكنهم تعديل موقعهم مباشرة عبر API\n";
                echo "   💡 الحل: إزالة latitude/longitude من fillable أو إضافة middleware للتحقق\n";
            } else {
                echo "   ✅ حقول الموقع محمية من التعديل المباشر\n";
            }
        }
        
        echo "\n2. حماية الإعلانات:\n";
        if (isset($this->results['ad_models'])) {
            $unprotectedModels = 0;
            foreach ($this->results['ad_models'] as $modelName => $data) {
                if ($data['uses_empty_guarded']) {
                    $unprotectedModels++;
                }
            }
            if ($unprotectedModels > 0) {
                echo "   ⚠️ $unprotectedModels نموذج يستخدم guarded فارغ\n";
                echo "   💡 الحل: تحديد fillable بدقة أو استخدام guarded محدد\n";
            } else {
                echo "   ✅ نماذج الإعلانات محمية بشكل مناسب\n";
            }
        }
        
        echo "\n3. Validation في Controllers:\n";
        if (isset($this->results['controllers'])) {
            $hasProperValidation = false;
            foreach ($this->results['controllers'] as $data) {
                if ($data['has_proper_validation_rules']) {
                    $hasProperValidation = true;
                    break;
                }
            }
            if ($hasProperValidation) {
                echo "   ✅ يوجد validation مناسب في بعض Controllers\n";
            } else {
                echo "   ⚠️ لا يوجد validation كافي لحقول الموقع\n";
                echo "   💡 الحل: إضافة validation rules مثل between:-90,90 للـ latitude\n";
            }
        }
        
        echo "\n" . str_repeat("=", 80) . "\n";
        echo "🏁 انتهى التحليل\n";
        
        // حفظ النتائج في ملف
        $reportFile = __DIR__ . '/security_report_' . date('Y-m-d_H-i-s') . '.json';
        file_put_contents($reportFile, json_encode([
            'timestamp' => date('Y-m-d H:i:s'),
            'vulnerabilities' => $this->vulnerabilities,
            'recommendations' => $this->recommendations,
            'results' => $this->results,
            'risk_level' => $riskLevel
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo "📄 تم حفظ التقرير المفصل في: $reportFile\n";
    }
}

// تشغيل الاختبار
try {
    $test = new SimpleSecurityTest();
    $test->runTests();
} catch (Exception $e) {
    echo "❌ خطأ عام في تشغيل الاختبارات: " . $e->getMessage() . "\n";
}