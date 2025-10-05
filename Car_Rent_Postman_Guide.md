# 🚘 دليل Postman الشامل لقسم تأجير السيارات (Car Rent)

## 📋 نظرة عامة
هذا الدليل يغطي جميع API endpoints الخاصة بقسم تأجير السيارات في تطبيق Dubai Sale، بما في ذلك الاستعراض العام، البحث، عرض إعلان محدد، وعمليات الإنشاء/التحديث/الحذف، بالإضافة إلى تفعيل صندوق العروض (Offers Box) وإدارة الإعلانات للأدمن.

## 🌐 Base URL
```
http://localhost:8000/api
```

## 🔐 المصادقة (Authentication)
- عمليات القراءة العامة (قائمة الإعلانات، عرض إعلان، البحث، عروض الصندوق) لا تتطلب توكن.
- عمليات الإنشاء/التعديل/الحذف وتفعيل صندوق العروض تتطلب إرسال توكن مستخدم صالح:
```
Authorization: Bearer YOUR_USER_TOKEN_HERE
```
- يوصى أن تكون عمليات الإدارة (Admin) محمية بتوكن أدمن.

---
# 👥 القسم الأول: API للمستخدمين (عام — Public)

### 1.1 📋 الحصول على جميع إعلانات تأجير السيارات
**GET** `/car-rent`

**الوصف:** جلب جميع الإعلانات المعتمدة والنشطة مع فلاتر متعددة.

**Query Parameters:**
- `make` (اختياري): الشركة المصنّعة
- `model` (اختياري): الموديل
- `trim` (اختياري): الفئة/الفئة الفرعية
- `year` (اختياري): سنة الصنع
- `emirate` (اختياري): الإمارة
- `district` (اختياري): المنطقة
- `area` (اختياري): الحي
- `min_price` / `max_price` (اختياري): نطاق السعر العام
- `min_day_rent` / `max_day_rent` (اختياري): نطاق سعر الإيجار اليومي
- `min_month_rent` / `max_month_rent` (اختياري): نطاق سعر الإيجار الشهري
- `page` (اختياري): رقم الصفحة (الترقيم 15 عنصر/صفحة)

**أمثلة:**
```
GET /api/car-rent
GET /api/car-rent?emirate=Dubai&make=Toyota&model=Yaris&year=2022
GET /api/car-rent?min_day_rent=100&max_day_rent=200&district=Deira
```

**مثال استجابة (مختصر):**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 101,
      "title": "تويوتا يارس للتأجير اليومي",
      "description": "سيارة اقتصادية بحالة ممتازة",
      "emirate": "Dubai",
      "district": "Deira",
      "area": "Al Rigga",
      "make": "Toyota",
      "model": "Yaris",
      "trim": "LE",
      "year": 2022,
      "day_rent": 150,
      "month_rent": 2200,
      "price": null,
      "advertiser_name": "Ali Rent",
      "phone_number": "+971501234567",
      "whatsapp": "+971501234567",
      "main_image_url": "http://localhost:8000/storage/car_rent/main/101.jpg",
      "thumbnail_images_urls": [],
      "views": 12,
      "status": "Valid",
      "category": "Car Rent"
    }
  ],
  "per_page": 15,
  "total": 1
}
```

### 1.2 🔍 البحث المتقدم
**GET** `/car-rent/search`

**الوصف:** بحث متقدم مع دعم الكلمات المفتاحية وخيارات ترتيب متعددة.

**Query Parameters:**
- `emirate`, `make`, `model`, `trim`, `year`, `district`, `area` (اختياري)
- `min_price`, `max_price` (اختياري)
- `min_day_rent`, `max_day_rent` (اختياري)
- `min_month_rent`, `max_month_rent` (اختياري)
- `keyword` (اختياري): بحث في العنوان/الوصف/الماركة/الموديل/الفئة
- `sort_by` (اختياري): `latest` (افتراضي) | `price_low` | `price_high` | `most_viewed`
- `per_page` (اختياري): من 1 إلى 50 (افتراضي 15)
- `page` (اختياري): رقم الصفحة

**أمثلة:**
```
GET /api/car-rent/search?keyword=yar&emirate=Dubai&sort_by=price_low&per_page=10
GET /api/car-rent/search?make=Toyota&model=Yaris&year=2022&district=Deira
GET /api/car-rent/search?min_month_rent=1500&max_month_rent=3000&sort_by=most_viewed
```

### 1.3 👁️ عرض إعلان محدد
**GET** `/car-rent/{id}`

- يزيد العداد views تلقائياً عند الفتح.

**مثال:**
```
GET /api/car-rent/101
```

**مثال استجابة (مختصر):**
```json
{
  "id": 101,
  "title": "تويوتا يارس للتأجير اليومي",
  "description": "سيارة اقتصادية بحالة ممتازة",
  "emirate": "Dubai",
  "district": "Deira",
  "area": "Al Rigga",
  "make": "Toyota",
  "model": "Yaris",
  "trim": "LE",
  "year": 2022,
  "day_rent": 150,
  "month_rent": 2200,
  "price": null,
  "advertiser_name": "Ali Rent",
  "phone_number": "+971501234567",
  "whatsapp": "+971501234567",
  "main_image_url": "http://localhost:8000/storage/car_rent/main/101.jpg",
  "thumbnail_images_urls": [],
  "views": 13,
  "status": "Valid",
  "category": "Car Rent"
}
```

### 1.4 🎁 إعلانات صندوق العروض (Offers Box)
**GET** `/car-rent/offers-box/ads`

- المعامل `limit` (اختياري، افتراضي 10): عدد الإعلانات المطلوبة.

**أمثلة:**
```
GET /api/car-rent/offers-box/ads
GET /api/car-rent/offers-box/ads?limit=5
```

---
# 🔐 القسم الثاني: العمليات المحمية (Authenticated)
> يجب إرسال توكن المستخدم في جميع الطلبات التالية.

### 2.1 ➕ إنشاء إعلان تأجير جديد
**POST** `/car-rent-ads`

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: multipart/form-data
```

**Body (Form Data):**
- `title` (مطلوب)
- `description` (مطلوب)
- `emirate` (مطلوب)
- `district` (اختياري)
- `area` (اختياري)
- `make` (اختياري)
- `model` (اختياري)
- `trim` (اختياري)
- `year` (اختياري، 1900 إلى السنة الحالية+1)
- `day_rent` (اختياري، رقم ≥0)
- `month_rent` (اختياري، رقم ≥0)
- `price` (اختياري، رقم ≥0)
- `location` (اختياري، حتى 500 حرف)
- `advertiser_name` (مطلوب)
- `phone_number` (مطلوب)
- `whatsapp` (اختياري)
- `main_image` (مطلوب: ملف صورة حتى 5MB)
- `thumbnail_images[]` (اختياري: ملفات صور حتى 5MB للصورة)
- حقول الخطة (اختياري): `plan_type`, `plan_days`, `plan_expires_at`

**استجابة ناجحة (201 مختصر):**
```json
{
  "success": true,
  "message": "تم إضافة الإعلان بنجاح",
  "data": {
    "id": 123,
    "title": "Hyundai Accent 2021",
    "make": "Hyundai",
    "model": "Accent",
    "year": 2021,
    "price": null,
    "main_image": "car_rent/main/abc123.jpg",
    "thumbnail_images_urls": []
  }
}
```

ملاحظة: إذا كان وضع الموافقة اليدوي مفعلاً في إعدادات النظام، سيتم حفظ الإعلان بحالة `Pending` إلى أن يوافق الأدمن، وإلا سيتم نشره مباشرة بحالة `Valid`.

### 2.2 ✏️ تحديث إعلان
**PUT/PATCH** `/car-rent-ads/{id}`

- جميع الحقول اختيارية (يتم تحديث المُرسل فقط)
- يمكن استبدال `main_image` وإضافة المزيد من `thumbnail_images[]`

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: multipart/form-data
```

**أمثلة:**
```
PUT /api/car-rent-ads/123
Body: description=حالة ممتازة وصيانة وكالة&day_rent=130
```

**استجابة (مختصر):**
```json
{
  "success": true,
  "message": "تم تحديث الإعلان بنجاح",
  "data": { "id": 123, "day_rent": 130 }
}
```

### 2.3 🗑️ حذف إعلان
**DELETE** `/car-rent-ads/{id}`

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: application/json
```

**مثال:**
```
DELETE /api/car-rent-ads/123
```

**استجابة ناجحة:**
```json
{ "success": true }
```

### 2.4 ⭐ تفعيل صندوق العروض (Offers Box)
**POST** `/offers-box/activate`

- يقوم بترقية إعلانك ليظهر في صندوق العروض لفترة محددة.

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "ad_id": 123,
  "category_slug": "car_rent",
  "days": 7
}
```

**استجابة (مثال):**
```json
{
  "message": "Ad has been successfully promoted to the Offers Box!",
  "total_price": 35.0,
  "expires_at": "2025-09-24T10:15:30.000000Z"
}
```

ملاحظات:
- إذا كان الإعلان مفعّل مسبقاً في الصندوق ستحصل على خطأ (422).
- في حال وصول الصندوق للحد الأقصى لهذا القسم سيتم إرجاع خطأ (422).

---
# 🛡️ القسم الثالث: إدارة الإعلانات (Admin)

> يُفترض استخدام توكن أدمن. (المسارات الحالية بدون بادئة `/admin` حسب الكود القائم)

### 3.1 📊 إحصائيات سريعة
**GET** `/car-rent/stats`

**مثال استجابة:**
```json
{
  "total_ads": 120,
  "active_ads": 75,
  "pending_ads": 30,
  "rejected_ads": 15
}
```

### 3.2 🗂️ إدارة قائمة الإعلانات مع فلاتر
**GET** `/car-rent-ads`

**Query Parameters:**
- `status` (اختياري): `Valid` | `Pending` | `Rejected`
- `approved` (اختياري): `true` | `false`

**أمثلة:**
```
GET /api/car-rent-ads?status=Pending
GET /api/car-rent-ads?approved=true
```

### 3.3 ✅ اعتماد إعلان
**POST** `/car-rent-ads/{id}/approve`

**استجابة:**
```json
{ "success": true }
```

### 3.4 ❌ رفض إعلان
**POST** `/car-rent-ads/{id}/reject`

**استجابة:**
```json
{ "success": true }
```

---
## 🧾 هيكل بيانات الإعلان
- الحقول المخفية في الاستجابة: `main_image`, `thumbnail_images` (يتم إرجاع روابطها عبر حقول مشتقة)
- الحقول المضافة تلقائياً في الاستجابة: `main_image_url`, `thumbnail_images_urls`, `status`, `category`

**مثال عنصر إعلان في الاستجابة:**
```json
{
  "id": 101,
  "title": "تويوتا يارس للتأجير اليومي",
  "description": "سيارة اقتصادية بحالة ممتازة",
  "emirate": "Dubai",
  "district": "Deira",
  "area": "Al Rigga",
  "make": "Toyota",
  "model": "Yaris",
  "trim": "LE",
  "year": 2022,
  "day_rent": 150,
  "month_rent": 2200,
  "price": null,
  "location": "بالقرب من المترو",
  "advertiser_name": "Ali Rent",
  "phone_number": "+971501234567",
  "whatsapp": "+971501234567",
  "views": 25,
  "rank": null,
  "active_offers_box_status": false,
  "active_offers_box_days": null,
  "active_offers_box_expires_at": null,
  "plan_type": null,
  "plan_days": null,
  "plan_expires_at": null,
  "admin_approved": true,
  "add_status": "Valid",
  "main_image_url": "http://localhost:8000/storage/car_rent/main/101.jpg",
  "thumbnail_images_urls": [],
  "status": "Valid",
  "category": "Car Rent"
}
```

---
## 📝 ملاحظات عملية
- الموافقة اليدوية: يتحكم بها مفتاح النظام `manual_approval_mode_car_rent` (مع وجود بديل عام `manual_approval_mode`). عند تفعيلها تُنشأ الإعلانات بحالة `Pending` وإلا تُنشر مباشرة `Valid`.
- التخزين: يتم حفظ الصور في `storage/app/public/car_rent/main` و `storage/app/public/car_rent/thumbnails`؛ تأكد من تنفيذ `php artisan storage:link` لعرض الروابط.
- الفرز في البحث: يدعم `latest`, `price_low`, `price_high`, `most_viewed`.
- ترتيب السعر: في البحث يتم استخدام القيمة المتوفرة من `price` أو `day_rent` أو `month_rent` (الأولى المتاحة).
- Offers Box: يعتمد على إعدادات القسم في جدول `offer_box_settings` (مثل `price_per_day` و`max_ads`)؛ ستتلقى أخطاء مناسبة عند تجاوز السعة أو إعادة التفعيل.