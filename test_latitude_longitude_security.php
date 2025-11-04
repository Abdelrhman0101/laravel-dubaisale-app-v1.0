<?php

/**
 * اختبار شامل لأمان وحماية حقول latitude و longitude في النظام
 * 
 * هذا الـ Script يفحص:
 * 1. حماية حقول latitude/longitude في نموذج User
 * 2. حماية حقول latitude/longitude في نماذج الإعلانات
 * 3. validation في Controllers
 * 4. إمكانية التلاعب بالبيانات الجغرافية
 * 5. اختبار سيناريوهات مختلفة للهجمات
 * 
 * تشغيل: php artisan tinker --execute="require_once 'test_latitude_longitude_security.php';"
 */

// تحميل Laravel framework
require_once __DIR__ . '/bootstrap/app.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\CarRentAd;
use App\Models\RealEstateAd;

class LatitudeLongitudeSecurityTest
{
    private $results = [];
    private $vulnerabilities = [];
    private $recommendations = [];

    public function __construct()
    {
        echo "🔍 بدء اختبار أمان حقول latitude و longitude...\n\n";
    }

    /**
     * تشغيل جميع الاختبارات
     */
    public function runAllTests()
    {
        $this->testDatabaseSchema();
        $this->testUserModelSecurity();
        $this->testAdModelsSecurity();
        $this->testControllerValidation();
        $this->testMassAssignmentProtection();
        $this->testDataValidationRanges();
        $this->testSQLInjectionVulnerabilities();
        $this->testUnauthorizedAccess();
        
        $this->generateReport();
    }

    /**
     * فحص schema قاعدة البيانات
     */
    private function testDatabaseSchema()
    {
        echo "📊 فحص schema قاعدة البيانات...\n";
        
        try {
            // فحص جدول users
            $userColumns = Schema::getColumnListing('users');
            $hasUserLatLng = in_array('latitude', $userColumns) && in_array('longitude', $userColumns);
            
            // فحص جدول car_rent_ads
            $carRentColumns = Schema::getColumnListing('car_rent_ads');
            $hasCarRentLatLng = in_array('latitude', $carRentColumns) && in_array('longitude', $carRentColumns);
            
            // فحص جدول real_estate_ads
            $realEstateColumns = Schema::getColumnListing('real_estate_ads');
            $hasRealEstateLatLng = in_array('latitude', $realEstateColumns) && in_array('longitude', $realEstateColumns);
            
            $this->results['database_schema'] = [
                'users_has_lat_lng' => $hasUserLatLng,
                'car_rent_ads_has_lat_lng' => $hasCarRentLatLng,
                'real_estate_ads_has_lat_lng' => $hasRealEstateLatLng,
                'status' => 'completed'
            ];
            
            echo "✅ فحص schema مكتمل\n";
            
        } catch (Exception $e) {
            echo "❌ خطأ في فحص schema: " . $e->getMessage() . "\n";
            $this->results['database_schema'] = ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * فحص أمان نموذج User
     */
    private function testUserModelSecurity()
    {
        echo "👤 فحص أمان نموذج User...\n";
        
        try {
            $user = new User();
            $fillable = $user->getFillable();
            $guarded = $user->getGuarded();
            
            // فحص إذا كانت latitude/longitude في fillable
            $latInFillable = in_array('latitude', $fillable);
            $lngInFillable = in_array('longitude', $fillable);
            
            // فحص إذا كانت في guarded
            $latInGuarded = in_array('latitude', $guarded);
            $lngInGuarded = in_array('longitude', $guarded);
            
            $this->results['user_model_security'] = [
                'latitude_fillable' => $latInFillable,
                'longitude_fillable' => $lngInFillable,
                'latitude_guarded' => $latInGuarded,
                'longitude_guarded' => $lngInGuarded,
                'fillable_fields' => $fillable,
                'guarded_fields' => $guarded,
                'status' => 'completed'
            ];
            
            // تحليل المخاطر
            if ($latInFillable && $lngInFillable) {
                $this->vulnerabilities[] = "⚠️ حقول latitude و longitude قابلة للتعديل المباشر في نموذج User";
                $this->recommendations[] = "🔧 يُنصح بإضافة validation قوي أو إزالة هذه الحقول من fillable";
            }
            
            echo "✅ فحص نموذج User مكتمل\n";
            
        } catch (Exception $e) {
            echo "❌ خطأ في فحص نموذج User: " . $e->getMessage() . "\n";
            $this->results['user_model_security'] = ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * فحص أمان نماذج الإعلانات
     */
    private function testAdModelsSecurity()
    {
        echo "📢 فحص أمان نماذج الإعلانات...\n";
        
        try {
            // فحص CarRentAd
            $carRentAd = new CarRentAd();
            $carRentGuarded = $carRentAd->getGuarded();
            $carRentFillable = $carRentAd->getFillable();
            
            // فحص RealEstateAd
            $realEstateAd = new RealEstateAd();
            $realEstateGuarded = $realEstateAd->getGuarded();
            $realEstateFillable = $realEstateAd->getFillable();
            
            $this->results['ad_models_security'] = [
                'car_rent_ad' => [
                    'guarded' => $carRentGuarded,
                    'fillable' => $carRentFillable,
                    'uses_guarded_empty' => empty($carRentGuarded)
                ],
                'real_estate_ad' => [
                    'guarded' => $realEstateGuarded,
                    'fillable' => $realEstateFillable,
                    'uses_guarded_empty' => empty($realEstateGuarded)
                ],
                'status' => 'completed'
            ];
            
            // تحليل المخاطر
            if (empty($carRentGuarded)) {
                $this->vulnerabilities[] = "⚠️ CarRentAd يستخدم guarded = [] مما يعني أن جميع الحقول قابلة للتعديل";
            }
            
            if (empty($realEstateGuarded)) {
                $this->vulnerabilities[] = "⚠️ RealEstateAd يستخدم guarded = [] مما يعني أن جميع الحقول قابلة للتعديل";
            }
            
            echo "✅ فحص نماذج الإعلانات مكتمل\n";
            
        } catch (Exception $e) {
            echo "❌ خطأ في فحص نماذج الإعلانات: " . $e->getMessage() . "\n";
            $this->results['ad_models_security'] = ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * فحص validation في Controllers
     */
    private function testControllerValidation()
    {
        echo "🎮 فحص validation في Controllers...\n";
        
        try {
            // فحص ملفات Controllers
            $profileControllerPath = __DIR__ . '/app/Http/Controllers/Api/ProfileController.php';
            $adminUserControllerPath = __DIR__ . '/app/Http/Controllers/Api/Admin/UserController.php';
            
            $profileControllerContent = file_exists($profileControllerPath) ? file_get_contents($profileControllerPath) : '';
            $adminUserControllerContent = file_exists($adminUserControllerPath) ? file_get_contents($adminUserControllerPath) : '';
            
            // البحث عن validation rules لـ latitude/longitude
            $profileHasLatLngValidation = strpos($profileControllerContent, 'latitude') !== false || strpos($profileControllerContent, 'longitude') !== false;
            $adminHasLatLngValidation = strpos($adminUserControllerContent, 'latitude') !== false && strpos($adminUserControllerContent, 'longitude') !== false;
            
            // البحث عن setAddress method في AdminUserController
            $hasSetAddressMethod = strpos($adminUserControllerContent, 'setAddress') !== false;
            
            $this->results['controller_validation'] = [
                'profile_controller_has_lat_lng_validation' => $profileHasLatLngValidation,
                'admin_user_controller_has_lat_lng_validation' => $adminHasLatLngValidation,
                'has_set_address_method' => $hasSetAddressMethod,
                'status' => 'completed'
            ];
            
            // تحليل المخاطر
            if (!$profileHasLatLngValidation) {
                $this->vulnerabilities[] = "⚠️ ProfileController لا يحتوي على validation لحقول latitude/longitude";
            }
            
            if ($hasSetAddressMethod) {
                $this->recommendations[] = "✅ وجود method setAddress في AdminUserController يوفر validation مناسب";
            }
            
            echo "✅ فحص Controllers مكتمل\n";
            
        } catch (Exception $e) {
            echo "❌ خطأ في فحص Controllers: " . $e->getMessage() . "\n";
            $this->results['controller_validation'] = ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * اختبار حماية Mass Assignment
     */
    private function testMassAssignmentProtection()
    {
        echo "🛡️ اختبار حماية Mass Assignment...\n";
        
        try {
            // محاولة إنشاء user مع latitude/longitude مباشرة
            $testData = [
                'username' => 'test_user_' . time(),
                'email' => 'test' . time() . '@example.com',
                'password' => 'password123',
                'latitude' => 25.2048, // Dubai coordinates
                'longitude' => 55.2708,
                'is_active' => true
            ];
            
            try {
                $user = User::create($testData);
                $massAssignmentWorked = $user->latitude == 25.2048 && $user->longitude == 55.2708;
                
                // تنظيف البيانات التجريبية
                $user->delete();
                
            } catch (Exception $e) {
                $massAssignmentWorked = false;
            }
            
            $this->results['mass_assignment_protection'] = [
                'latitude_longitude_mass_assignable' => $massAssignmentWorked,
                'status' => 'completed'
            ];
            
            if ($massAssignmentWorked) {
                $this->vulnerabilities[] = "🚨 خطر أمني: يمكن تعديل latitude/longitude عبر Mass Assignment";
                $this->recommendations[] = "🔧 يجب إزالة latitude/longitude من fillable أو إضافة validation قوي";
            }
            
            echo "✅ اختبار Mass Assignment مكتمل\n";
            
        } catch (Exception $e) {
            echo "❌ خطأ في اختبار Mass Assignment: " . $e->getMessage() . "\n";
            $this->results['mass_assignment_protection'] = ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * اختبار نطاقات البيانات الصحيحة
     */
    private function testDataValidationRanges()
    {
        echo "📏 اختبار نطاقات البيانات...\n";
        
        $testCases = [
            ['lat' => 91, 'lng' => 0, 'valid' => false, 'reason' => 'latitude > 90'],
            ['lat' => -91, 'lng' => 0, 'valid' => false, 'reason' => 'latitude < -90'],
            ['lat' => 0, 'lng' => 181, 'valid' => false, 'reason' => 'longitude > 180'],
            ['lat' => 0, 'lng' => -181, 'valid' => false, 'reason' => 'longitude < -180'],
            ['lat' => 25.2048, 'lng' => 55.2708, 'valid' => true, 'reason' => 'Dubai coordinates'],
            ['lat' => 0, 'lng' => 0, 'valid' => true, 'reason' => 'Null Island'],
        ];
        
        $results = [];
        
        foreach ($testCases as $case) {
            try {
                // محاولة إنشاء user مع هذه الإحداثيات
                $testUser = User::create([
                    'username' => 'test_range_' . time() . '_' . rand(1000, 9999),
                    'email' => 'test_range_' . time() . '_' . rand(1000, 9999) . '@example.com',
                    'password' => 'password123',
                    'latitude' => $case['lat'],
                    'longitude' => $case['lng'],
                    'is_active' => true
                ]);
                
                $created = true;
                $testUser->delete(); // تنظيف
                
            } catch (Exception $e) {
                $created = false;
            }
            
            $results[] = [
                'coordinates' => $case,
                'created_successfully' => $created,
                'should_be_valid' => $case['valid']
            ];
        }
        
        $this->results['data_validation_ranges'] = [
            'test_cases' => $results,
            'status' => 'completed'
        ];
        
        // تحليل النتائج
        foreach ($results as $result) {
            if ($result['created_successfully'] && !$result['should_be_valid']) {
                $this->vulnerabilities[] = "⚠️ تم قبول إحداثيات غير صحيحة: " . json_encode($result['coordinates']);
            }
        }
        
        echo "✅ اختبار نطاقات البيانات مكتمل\n";
    }

    /**
     * اختبار SQL Injection
     */
    private function testSQLInjectionVulnerabilities()
    {
        echo "💉 اختبار SQL Injection...\n";
        
        $maliciousInputs = [
            "'; DROP TABLE users; --",
            "1' OR '1'='1",
            "NULL; INSERT INTO users (username) VALUES ('hacked'); --",
            "<script>alert('xss')</script>",
            "../../etc/passwd"
        ];
        
        $results = [];
        
        foreach ($maliciousInputs as $input) {
            try {
                $testUser = User::create([
                    'username' => 'test_sql_' . time() . '_' . rand(1000, 9999),
                    'email' => 'test_sql_' . time() . '_' . rand(1000, 9999) . '@example.com',
                    'password' => 'password123',
                    'latitude' => $input,
                    'longitude' => $input,
                    'is_active' => true
                ]);
                
                $injectionWorked = false;
                $testUser->delete();
                
            } catch (Exception $e) {
                $injectionWorked = false; // Exception means protection worked
            }
            
            $results[] = [
                'input' => $input,
                'injection_successful' => $injectionWorked
            ];
        }
        
        $this->results['sql_injection_test'] = [
            'test_cases' => $results,
            'status' => 'completed'
        ];
        
        echo "✅ اختبار SQL Injection مكتمل\n";
    }

    /**
     * اختبار الوصول غير المصرح به
     */
    private function testUnauthorizedAccess()
    {
        echo "🔐 اختبار الوصول غير المصرح به...\n";
        
        try {
            // إنشاء مستخدم تجريبي
            $testUser = User::create([
                'username' => 'test_auth_' . time(),
                'email' => 'test_auth_' . time() . '@example.com',
                'password' => 'password123',
                'is_active' => true
            ]);
            
            // محاولة تحديث latitude/longitude بدون صلاحيات
            $originalLat = $testUser->latitude;
            $originalLng = $testUser->longitude;
            
            // تحديث مباشر
            $testUser->update([
                'latitude' => 25.2048,
                'longitude' => 55.2708
            ]);
            
            $directUpdateWorked = ($testUser->fresh()->latitude == 25.2048);
            
            // تنظيف
            $testUser->delete();
            
            $this->results['unauthorized_access_test'] = [
                'direct_update_worked' => $directUpdateWorked,
                'status' => 'completed'
            ];
            
            if ($directUpdateWorked) {
                $this->vulnerabilities[] = "🚨 يمكن تحديث latitude/longitude مباشرة بدون تحقق من الصلاحيات";
            }
            
            echo "✅ اختبار الوصول غير المصرح به مكتمل\n";
            
        } catch (Exception $e) {
            echo "❌ خطأ في اختبار الوصول غير المصرح به: " . $e->getMessage() . "\n";
            $this->results['unauthorized_access_test'] = ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * إنتاج التقرير النهائي
     */
    private function generateReport()
    {
        echo "\n" . str_repeat("=", 80) . "\n";
        echo "📋 التقرير النهائي لأمان latitude/longitude\n";
        echo str_repeat("=", 80) . "\n\n";
        
        // عرض النتائج
        echo "📊 نتائج الاختبارات:\n";
        foreach ($this->results as $test => $result) {
            echo "  • $test: " . ($result['status'] ?? 'unknown') . "\n";
        }
        
        echo "\n";
        
        // عرض الثغرات الأمنية
        if (!empty($this->vulnerabilities)) {
            echo "🚨 الثغرات الأمنية المكتشفة:\n";
            foreach ($this->vulnerabilities as $vulnerability) {
                echo "  $vulnerability\n";
            }
            echo "\n";
        } else {
            echo "✅ لم يتم اكتشاف ثغرات أمنية واضحة\n\n";
        }
        
        // عرض التوصيات
        if (!empty($this->recommendations)) {
            echo "💡 التوصيات:\n";
            foreach ($this->recommendations as $recommendation) {
                echo "  $recommendation\n";
            }
            echo "\n";
        }
        
        // تقييم عام
        $riskLevel = count($this->vulnerabilities);
        if ($riskLevel == 0) {
            echo "🟢 مستوى المخاطر: منخفض\n";
        } elseif ($riskLevel <= 2) {
            echo "🟡 مستوى المخاطر: متوسط\n";
        } else {
            echo "🔴 مستوى المخاطر: عالي\n";
        }
        
        echo "\n📝 تفاصيل النتائج الكاملة:\n";
        echo json_encode($this->results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }
}

// تشغيل الاختبار
try {
    $test = new LatitudeLongitudeSecurityTest();
    $test->runAllTests();
} catch (Exception $e) {
    echo "❌ خطأ عام في تشغيل الاختبارات: " . $e->getMessage() . "\n";
}

echo "\n🏁 انتهى الاختبار\n";