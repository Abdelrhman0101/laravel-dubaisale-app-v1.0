# 🚗 دليل Postman الشامل لقسم خدمات السيارات (Car Services)

## 📋 نظرة عامة
هذا الدليل الشامل يغطي جميع API endpoints الخاصة بقسم خدمات السيارات في تطبيق Dubai Sale، مع أمثلة تفصيلية وواضحة لاستخدام Postman في جميع السيناريوهات المختلفة.

## 🌐 Base URL
```
http://localhost:8000/api
```

## 🔐 المصادقة (Authentication)

### للمستخدمين العاديين:
```
Authorization: Bearer YOUR_USER_TOKEN_HERE
```

### للأدمن:
```
Authorization: Bearer YOUR_ADMIN_TOKEN_HERE
```

### الحصول على Token:
**POST** `/auth/login`
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

---

# 👥 القسم الأول: API للمستخدمين العاديين

## 🌍 العمليات العامة (Public Endpoints)

### 1.1 📋 الحصول على جميع إعلانات خدمات السيارات
**GET** `/car-services`

**الوصف:** جلب جميع إعلانات خدمات السيارات المعتمدة والنشطة مع إمكانية الفلترة المتقدمة

**Headers:**
```
Content-Type: application/json
```

**Query Parameters:**
- `service_type` (optional): نوع الخدمة (oil_change, car_wash, general_maintenance, etc.)
- `emirate` (optional): الإمارة (Dubai, Abu Dhabi, Sharjah, etc.)
- `district` (optional): المنطقة
- `area` (optional): الحي
- `min_price` (optional): أقل سعر (رقم)
- `max_price` (optional): أعلى سعر (رقم)
- `page` (optional): رقم الصفحة (افتراضي: 1)
- `per_page` (optional): عدد النتائج في الصفحة (افتراضي: 15، أقصى: 50)

**أمثلة على الطلبات:**

**مثال 1: جلب جميع الإعلانات**
```
GET /api/car-services
```

**مثال 2: فلترة حسب نوع الخدمة والإمارة**
```
GET /api/car-services?service_type=oil_change&emirate=Dubai&page=1
```

**مثال 3: فلترة حسب نطاق السعر**
```
GET /api/car-services?min_price=100&max_price=500&per_page=20
```

**مثال على الاستجابة:**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "title": "خدمة تغيير زيت السيارة",
      "description": "خدمة تغيير زيت عالية الجودة",
      "emirate": "Dubai",
      "district": "Deira",
      "area": "Al Rigga",
      "service_type": "oil_change",
      "service_name": "تغيير زيت المحرك",
      "price": "150.00",
      "advertiser_name": "أحمد محمد",
      "phone_number": "+971501234567",
      "whatsapp": "+971501234567",
      "main_image_url": "http://localhost:8000/storage/car_services/main/image.jpg",
      "thumbnail_images_urls": [],
      "views": 25,
      "status": "Valid",
      "category": "Car Services"
    }
  ],
  "per_page": 15,
  "total": 1
}
```

### 1.2 🔍 البحث المتقدم في إعلانات خدمات السيارات
**GET** `/car-services/search`

**الوصف:** بحث متقدم وذكي مع فلترة شاملة وخيارات ترتيب متعددة

**Headers:**
```
Content-Type: application/json
```

**Query Parameters:**
- `emirate` (optional): الإمارة (Dubai, Abu Dhabi, Sharjah, Ajman, Ras Al Khaimah, Fujairah, Umm Al Quwain)
- `service_type` (optional): نوع الخدمة
- `district` (optional): المنطقة
- `area` (optional): الحي
- `min_price` (optional): أقل سعر (رقم)
- `max_price` (optional): أعلى سعر (رقم)
- `keyword` (optional): كلمة مفتاحية للبحث في العنوان والوصف واسم الخدمة
- `sort_by` (optional): نوع الترتيب
  - `latest`: الأحدث أولاً (افتراضي)
  - `price_low`: السعر من الأقل للأعلى
  - `price_high`: السعر من الأعلى للأقل
  - `most_viewed`: الأكثر مشاهدة
- `per_page` (optional): عدد النتائج في الصفحة (1-50، افتراضي: 15)
- `page` (optional): رقم الصفحة (افتراضي: 1)

**أمثلة على الطلبات:**

**مثال 1: بحث بسيط بكلمة مفتاحية**
```
GET /api/car-services/search?keyword=تنظيف
```

**مثال 2: بحث متقدم مع فلاتر متعددة**
```
GET /api/car-services/search?emirate=Dubai&service_type=car_wash&keyword=تنظيف&sort_by=price_low&per_page=10
```

**مثال 3: بحث حسب نطاق السعر مع ترتيب**
```
GET /api/car-services/search?min_price=50&max_price=200&sort_by=most_viewed&page=2
```

**مثال 4: بحث في منطقة محددة**
```
GET /api/car-services/search?emirate=Abu Dhabi&district=Al Khalidiyah&area=Corniche&sort_by=latest
```

### 1.3 🎛️ الحصول على بيانات الفلاتر
**GET** `/car-services/filters`

**الوصف:** جلب جميع الخيارات المتاحة للفلترة والبحث (الإمارات، أنواع الخدمات، المناطق)

**Headers:**
```
Content-Type: application/json
```

**مثال على الطلب:**
```
GET /api/car-services/filters
```

**مثال على الاستجابة:**
```json
{
  "emirates": [
    "Abu Dhabi",
    "Dubai",
    "Sharjah",
    "Ajman",
    "Ras Al Khaimah",
    "Fujairah",
    "Umm Al Quwain"
  ],
  "service_types": [
    {
      "name": "general_maintenance",
      "display_name": "صيانة عامة"
    },
    {
      "name": "oil_change",
      "display_name": "تغيير زيت"
    },
    {
      "name": "car_wash",
      "display_name": "غسيل سيارات"
    }
  ],
  "districts": [
    "Deira",
    "Bur Dubai",
    "Jumeirah",
    "Downtown"
  ]
}
```

### 1.4 👁️ عرض إعلان خدمة محدد
**GET** `/car-services/{id}`

**الوصف:** جلب تفاصيل إعلان خدمة محدد مع زيادة عداد المشاهدات تلقائياً

**Headers:**
```
Content-Type: application/json
```

**Path Parameters:**
- `id` (required): معرف الإعلان (رقم)

**أمثلة على الطلبات:**
```
GET /api/car-services/1
GET /api/car-services/25
```

**مثال على الاستجابة:**
```json
{
  "id": 1,
  "title": "خدمة تغيير زيت السيارة المتميزة",
  "description": "نقدم خدمة تغيير زيت عالية الجودة باستخدام أفضل أنواع الزيوت العالمية",
  "emirate": "Dubai",
  "district": "Deira",
  "area": "Al Rigga",
  "location": "بالقرب من مترو الاتحاد، شارع الرقة الرئيسي",
  "service_type": "oil_change",
  "service_name": "تغيير زيت المحرك",
  "price": "150.00",
  "advertiser_name": "أحمد محمد علي",
  "phone_number": "+971501234567",
  "whatsapp": "+971501234567",
  "main_image_url": "http://localhost:8000/storage/car_services/main/image.jpg",
  "thumbnail_images_urls": [
    "http://localhost:8000/storage/car_services/thumbnails/thumb1.jpg",
    "http://localhost:8000/storage/car_services/thumbnails/thumb2.jpg"
  ],
  "views": 26,
  "status": "Valid",
  "category": "Car Services",
  "created_at": "2024-01-15T10:30:00Z",
  "updated_at": "2024-01-15T10:30:00Z"
}
```

### 1.5 🎁 الحصول على إعلانات صندوق العروض
**GET** `/car-services/offers-box/ads`

**الوصف:** جلب إعلانات خدمات السيارات المميزة من صندوق العروض (إعلانات مدفوعة ونشطة)

**Headers:**
```
Content-Type: application/json
```

**Query Parameters:**
- `limit` (optional): عدد الإعلانات المطلوبة (افتراضي: 10، أقصى: 50)

**أمثلة على الطلبات:**

**مثال 1: جلب الإعلانات الافتراضية**
```
GET /api/car-services/offers-box/ads
```

**مثال 2: جلب عدد محدد من الإعلانات**
```
GET /api/car-services/offers-box/ads?limit=5
```

**مثال على الاستجابة:**
```json
{
  "data": [
    {
      "id": 3,
      "title": "خدمة غسيل سيارات متنقلة",
      "description": "خدمة غسيل احترافية في موقعك",
      "emirate": "Dubai",
      "district": "Jumeirah",
      "area": "Jumeirah 1",
      "service_type": "car_wash",
      "service_name": "غسيل سيارات متنقل",
      "price": "80.00",
      "advertiser_name": "محمد أحمد",
      "phone_number": "+971509876543",
      "whatsapp": "+971509876543",
      "main_image_url": "http://localhost:8000/storage/car_services/main/wash.jpg",
      "thumbnail_images_urls": [],
      "views": 45,
      "status": "Valid",
      "category": "Car Services",
      "in_offers_box": true,
      "offers_box_expires_at": "2024-02-15T23:59:59Z"
    }
  ],
  "total": 8,
  "limit": 10
}
```

### 1.6 🔧 الحصول على أنواع الخدمات
**GET** `/car-services/offers-box/ads`

**الوصف:** جلب جميع أنواع خدمات السيارات النشطة والمتاحة للاستخدام

**Headers:**
```
Content-Type: application/json
```

**مثال على الطلب:**
```
GET /api/car-service-types
```

**مثال على الاستجابة:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "general_maintenance",
      "display_name": "صيانة عامة",
      "is_active": true
    },
    {
      "id": 2,
      "name": "oil_change",
      "display_name": "تغيير زيت",
      "is_active": true
    },
    {
      "id": 3,
      "name": "car_wash",
      "display_name": "غسيل سيارات",
      "is_active": true
    },
    {
      "id": 4,
      "name": "tire_service",
      "display_name": "خدمات الإطارات",
      "is_active": true
    },
    {
      "id": 5,
      "name": "electrical_repair",
      "display_name": "إصلاح كهربائي",
      "is_active": true
    }
  ]
}
```

---

## 🔐 العمليات المحمية (Authenticated Endpoints)

### 2.1 ➕ إنشاء إعلان خدمة جديد
**POST** `/car-services-ads`

**الوصف:** إنشاء إعلان خدمة سيارات جديد مع رفع الصور وإدخال جميع التفاصيل المطلوبة

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: multipart/form-data
```

**Body (Form Data):**
- `title` (required): عنوان الإعلان (نص، 5-100 حرف)
- `description` (required): وصف الخدمة (نص، 20-1000 حرف)
- `emirate` (required): الإمارة (Dubai, Abu Dhabi, Sharjah, etc.)
- `district` (required): المنطقة (نص)
- `area` (required): الحي (نص)
- `service_type` (required): نوع الخدمة (يجب أن يكون من الأنواع المتاحة)
- `service_name` (required): اسم الخدمة (نص، 5-100 حرف)
- `price` (required): السعر (رقم، أكبر من 0)
- `location` (optional): الموقع التفصيلي (نص، حتى 255 حرف)
- `main_image` (required): الصورة الأساسية (ملف: jpg, png, gif - حد أقصى 5MB)
- `thumbnail_images[]` (optional): صور إضافية (ملفات: jpg, png, gif - حد أقصى 5MB لكل صورة، حتى 5 صور)

**مثال على الطلب في Postman:**

**الخطوة 1: إعداد Headers**
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
Content-Type: multipart/form-data
```

**الخطوة 2: إعداد Body (Form-data)**
```
KEY                 | VALUE                                           | TYPE
--------------------|------------------------------------------------|------
title               | خدمة تغيير زيت السيارة المتميزة                    | Text
description         | نقدم خدمة تغيير زيت عالية الجودة لجميع أنواع السيارات باستخدام أفضل أنواع الزيوت العالمية مع ضمان الجودة | Text
emirate             | Dubai                                          | Text
district            | Deira                                          | Text
area                | Al Rigga                                       | Text
service_type        | oil_change                                     | Text
service_name        | تغيير زيت المحرك والفلتر                          | Text
price               | 150                                            | Text
location            | بالقرب من مترو الاتحاد، شارع الرقة الرئيسي           | Text
main_image          | [اختر ملف الصورة الأساسية]                        | File
thumbnail_images[]  | [اختر الصورة الإضافية الأولى]                     | File
thumbnail_images[]  | [اختر الصورة الإضافية الثانية]                    | File
```

**مثال على الاستجابة الناجحة:**
```json
{
  "message": "تم إنشاء الإعلان بنجاح",
  "data": {
    "id": 15,
    "title": "خدمة تغيير زيت السيارة المتميزة",
    "description": "نقدم خدمة تغيير زيت عالية الجودة لجميع أنواع السيارات باستخدام أفضل أنواع الزيوت العالمية مع ضمان الجودة",
    "emirate": "Dubai",
    "district": "Deira",
    "area": "Al Rigga",
    "location": "بالقرب من مترو الاتحاد، شارع الرقة الرئيسي",
    "service_type": "oil_change",
    "service_name": "تغيير زيت المحرك والفلتر",
    "price": "150.00",
    "advertiser_name": "أحمد محمد علي",
    "phone_number": "+971501234567",
    "whatsapp": "+971501234567",
    "main_image_url": "http://localhost:8000/storage/car_services/main/15_main_image.jpg",
    "thumbnail_images_urls": [
      "http://localhost:8000/storage/car_services/thumbnails/15_thumb_1.jpg",
      "http://localhost:8000/storage/car_services/thumbnails/15_thumb_2.jpg"
    ],
    "views": 0,
    "status": "Pending",
    "approved": false,
    "category": "Car Services",
    "created_at": "2024-01-15T14:30:00Z",
    "updated_at": "2024-01-15T14:30:00Z"
  }
}
```

**أمثلة على أخطاء التحقق:**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["حقل العنوان مطلوب"],
    "price": ["يجب أن يكون السعر رقماً أكبر من 0"],
    "main_image": ["الصورة الأساسية مطلوبة"],
    "service_type": ["نوع الخدمة المحدد غير صحيح"]
  }
}
```

### 2.2 ✏️ تحديث إعلان خدمة
**PUT** `/car-services-ads/{id}`

**الوصف:** تحديث إعلان خدمة موجود (يمكن للمستخدم تحديث إعلاناته فقط)

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: multipart/form-data
```

**Path Parameters:**
- `id` (required): معرف الإعلان المراد تحديثه

**Body (Form Data):** جميع الحقول اختيارية - يتم تحديث الحقول المرسلة فقط
- `title` (optional): عنوان الإعلان الجديد
- `description` (optional): وصف الخدمة الجديد
- `emirate` (optional): الإمارة الجديدة
- `district` (optional): المنطقة الجديدة
- `area` (optional): الحي الجديد
- `service_type` (optional): نوع الخدمة الجديد
- `service_name` (optional): اسم الخدمة الجديد
- `price` (optional): السعر الجديد
- `location` (optional): الموقع التفصيلي الجديد
- `main_image` (optional): صورة أساسية جديدة (ستحل محل القديمة)
- `thumbnail_images[]` (optional): صور إضافية جديدة (ستحل محل القديمة)
- `remove_thumbnails` (optional): "true" لحذف جميع الصور الإضافية

**مثال على الطلب في Postman:**

**الخطوة 1: إعداد Headers**
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
Content-Type: multipart/form-data
```

**الخطوة 2: إعداد Body (Form-data) - تحديث السعر والوصف فقط**
```
KEY                 | VALUE                                           | TYPE
--------------------|------------------------------------------------|------
price               | 180                                            | Text
description         | خدمة تغيير زيت محسنة مع فحص شامل للسيارة وضمان لمدة شهر | Text
location            | الموقع الجديد: بجانب مول الإمارات                 | Text
```

**مثال على الاستجابة الناجحة:**
```json
{
  "message": "تم تحديث الإعلان بنجاح",
  "data": {
    "id": 15,
    "title": "خدمة تغيير زيت السيارة المتميزة",
    "description": "خدمة تغيير زيت محسنة مع فحص شامل للسيارة وضمان لمدة شهر",
    "price": "180.00",
    "location": "الموقع الجديد: بجانب مول الإمارات",
    "updated_at": "2024-01-15T16:45:00Z"
  }
}
```

### 2.3 🗑️ حذف إعلان خدمة
**DELETE** `/car-services-ads/{id}`

**الوصف:** حذف إعلان خدمة (يمكن للمستخدم حذف إعلاناته فقط)

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: application/json
```

**Path Parameters:**
- `id` (required): معرف الإعلان المراد حذفه

**أمثلة على الطلبات:**
```
DELETE /api/car-services-ads/1
DELETE /api/car-services-ads/25
```

**مثال على الاستجابة الناجحة:**
```json
{
  "message": "تم حذف الإعلان بنجاح"
}
```

**مثال على خطأ عدم الصلاحية:**
```json
{
  "message": "غير مصرح لك بحذف هذا الإعلان"
}
```

### 2.4 📋 الحصول على إعلانات المستخدم
**GET** `/my-ads`

**الوصف:** جلب جميع إعلانات المستخدم الحالي (سيارات وخدمات) مع إمكانية الفلترة

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: application/json
```

**Query Parameters:**
- `category` (optional): فلترة حسب الفئة ("car_sales" أو "car_services")
- `status` (optional): فلترة حسب الحالة ("Valid", "Pending", "Rejected")
- `page` (optional): رقم الصفحة (افتراضي: 1)
- `per_page` (optional): عدد النتائج في الصفحة (افتراضي: 15)

**أمثلة على الطلبات:**

**مثال 1: جلب جميع الإعلانات**
```
GET /api/my-ads
```

**مثال 2: جلب إعلانات الخدمات فقط**
```
GET /api/my-ads?category=car_services
```

**مثال 3: جلب الإعلانات المعلقة**
```
GET /api/my-ads?status=Pending&category=car_services
```

**مثال على الاستجابة:**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 15,
      "title": "خدمة تغيير زيت السيارة المتميزة",
      "category": "Car Services",
      "status": "Valid",
      "approved": true,
      "price": "180.00",
      "views": 12,
      "created_at": "2024-01-15T14:30:00Z",
      "updated_at": "2024-01-15T16:45:00Z"
    }
  ],
  "per_page": 15,
  "total": 1
}
```

### 2.5 🎁 تفعيل صندوق العروض
**POST** `/offers-box/activate`

**الوصف:** تفعيل إعلان في صندوق العروض المدفوع لزيادة الظهور

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "category_slug": "car_services",
  "ad_id": 15,
  "days": 7
}
```

**شرح الحقول:**
- `category_slug` (required): فئة الإعلان ("car_services" للخدمات)
- `ad_id` (required): معرف الإعلان المراد تفعيله
- `days` (required): عدد الأيام للتفعيل (1-30 يوم)

**أمثلة على الطلبات:**

**مثال 1: تفعيل لمدة أسبوع**
```json
{
  "category_slug": "car_services",
  "ad_id": 15,
  "days": 7
}
```

**مثال 2: تفعيل لمدة شهر**
```json
{
  "category_slug": "car_services",
  "ad_id": 20,
  "days": 30
}
```

**مثال على الاستجابة الناجحة:**
```json
{
  "message": "تم تفعيل الإعلان في صندوق العروض بنجاح",
  "data": {
    "ad_id": 15,
    "category": "car_services",
    "activated_at": "2024-01-15T18:00:00Z",
    "expires_at": "2024-01-22T18:00:00Z",
    "days": 7,
    "cost": "50.00 AED"
  }
}
```

**أمثلة على الأخطاء:**
```json
{
  "message": "الإعلان غير موجود أو لا تملك صلاحية الوصول إليه"
}
```

```json
{
  "message": "الإعلان مفعل بالفعل في صندوق العروض"
}
```

---

## 3. 👨‍💼 API للأدمن (Admin Endpoints)

> **ملاحظة:** جميع عمليات الأدمن تتطلب token خاص بالأدمن مع صلاحيات إدارية

### 3.1 🔐 الحصول على Admin Token
**POST** `/auth/admin/login`

**الوصف:** تسجيل دخول الأدمن للحصول على token إداري

**Headers:**
```
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "email": "admin@dubaisale.com",
  "password": "admin_password"
}
```

**مثال على الاستجابة:**
```json
{
  "message": "تم تسجيل الدخول بنجاح",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "user": {
    "id": 1,
    "email": "admin@dubaisale.com",
    "role": "admin"
  }
}
```

### 3.2 📊 إحصائيات إعلانات الخدمات
**GET** `/admin/car-services/stats`

**الوصف:** الحصول على إحصائيات شاملة لإعلانات الخدمات

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**مثال على الطلب:**
```
GET /api/admin/car-services/stats
```

**مثال على الاستجابة:**
```json
{
  "total_ads": 150,
  "pending_ads": 25,
  "approved_ads": 120,
  "rejected_ads": 5,
  "active_offers_box": 8,
  "total_views": 5420,
  "this_month_ads": 35,
  "service_types_count": 12
}
```

### 3.3 📋 إدارة جميع إعلانات الخدمات
**GET** `/admin/car-services`

**الوصف:** جلب جميع إعلانات الخدمات مع إمكانيات فلترة وبحث متقدمة للأدمن

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Query Parameters:**
- `status` (optional): فلترة حسب الحالة ("Valid", "Pending", "Rejected")
- `approved` (optional): فلترة حسب الموافقة ("true", "false")
- `emirate` (optional): فلترة حسب الإمارة
- `service_type` (optional): فلترة حسب نوع الخدمة
- `user_id` (optional): فلترة حسب المستخدم
- `search` (optional): البحث في العنوان والوصف
- `date_from` (optional): من تاريخ (YYYY-MM-DD)
- `date_to` (optional): إلى تاريخ (YYYY-MM-DD)
- `sort_by` (optional): ترتيب حسب ("created_at", "updated_at", "views", "price")
- `sort_direction` (optional): اتجاه الترتيب ("asc", "desc")
- `page` (optional): رقم الصفحة
- `per_page` (optional): عدد النتائج في الصفحة (افتراضي: 20)

**أمثلة على الطلبات:**

**مثال 1: جلب الإعلانات المعلقة**
```
GET /api/admin/car-services?status=Pending&sort_by=created_at&sort_direction=desc
```

**مثال 2: البحث في إعلانات دبي**
```
GET /api/admin/car-services?emirate=دبي&search=تغيير زيت
```

**مثال 3: إعلانات مستخدم معين**
```
GET /api/admin/car-services?user_id=15&per_page=10
```

### 3.4 ✅ الموافقة على إعلان
**PUT** `/admin/car-services/{id}/approve`

**الوصف:** الموافقة على إعلان خدمة معلق

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Path Parameters:**
- `id` (required): معرف الإعلان

**Body (JSON) - اختياري:**
```json
{
  "admin_notes": "تم الموافقة على الإعلان بعد مراجعة المحتوى"
}
```

**مثال على الطلب:**
```
PUT /api/admin/car-services/25/approve
```

**مثال على الاستجابة:**
```json
{
  "message": "تم الموافقة على الإعلان بنجاح",
  "data": {
    "id": 25,
    "title": "خدمة تغيير زيت السيارة",
    "status": "Valid",
    "approved": true,
    "approved_at": "2024-01-15T20:30:00Z",
    "admin_notes": "تم الموافقة على الإعلان بعد مراجعة المحتوى"
  }
}
```

### 3.5 ❌ رفض إعلان
**PUT** `/admin/car-services/{id}/reject`

**الوصف:** رفض إعلان خدمة مع إمكانية إضافة سبب الرفض

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Path Parameters:**
- `id` (required): معرف الإعلان

**Body (JSON):**
```json
{
  "rejection_reason": "المحتوى غير مناسب أو يحتوي على معلومات مضللة",
  "admin_notes": "يرجى مراجعة المحتوى وإعادة النشر"
}
```

**مثال على الطلب:**
```
PUT /api/admin/car-services/30/reject
```

**مثال على الاستجابة:**
```json
{
  "message": "تم رفض الإعلان",
  "data": {
    "id": 30,
    "title": "خدمة غير مناسبة",
    "status": "Rejected",
    "approved": false,
    "rejected_at": "2024-01-15T20:45:00Z",
    "rejection_reason": "المحتوى غير مناسب أو يحتوي على معلومات مضللة",
    "admin_notes": "يرجى مراجعة المحتوى وإعادة النشر"
  }
}
```

### 3.6 🗑️ حذف إعلان (أدمن)
**DELETE** `/admin/car-services/{id}`

**الوصف:** حذف إعلان خدمة نهائياً (صلاحية أدمن فقط)

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Path Parameters:**
- `id` (required): معرف الإعلان

**Body (JSON) - اختياري:**
```json
{
  "deletion_reason": "مخالف لسياسات الموقع"
}
```

**مثال على الطلب:**
```
DELETE /api/admin/car-services/35
```

**مثال على الاستجابة:**
```json
{
  "message": "تم حذف الإعلان نهائياً",
  "deleted_ad": {
    "id": 35,
    "title": "إعلان محذوف",
    "deleted_at": "2024-01-15T21:00:00Z",
    "deletion_reason": "مخالف لسياسات الموقع"
  }
}
```

### 3.7 🏷️ إدارة أنواع الخدمات

#### 3.7.1 📋 جلب جميع أنواع الخدمات
**GET** `/admin/car-service-types`

**الوصف:** جلب جميع أنواع الخدمات (نشطة وغير نشطة) للأدمن

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Query Parameters:**
- `active` (optional): فلترة حسب الحالة ("true", "false")
- `search` (optional): البحث في الاسم

**مثال على الطلب:**
```
GET /api/admin/car-service-types
```

**مثال على الاستجابة:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "صيانة",
      "active": true,
      "ads_count": 45,
      "created_at": "2024-01-01T10:00:00Z",
      "updated_at": "2024-01-10T15:30:00Z"
    },
    {
      "id": 2,
      "name": "تنظيف",
      "active": true,
      "ads_count": 23,
      "created_at": "2024-01-01T10:00:00Z",
      "updated_at": "2024-01-05T12:00:00Z"
    }
  ],
  "total": 12
}
```

#### 3.7.2 ➕ إضافة نوع خدمة جديد
**POST** `/admin/car-service-types`

**الوصف:** إضافة نوع خدمة جديد

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "name": "تأمين السيارات",
  "active": true
}
```

**شرح الحقول:**
- `name` (required): اسم نوع الخدمة (يجب أن يكون فريد)
- `active` (optional): حالة النشاط (افتراضي: true)

**مثال على الاستجابة:**
```json
{
  "message": "تم إضافة نوع الخدمة بنجاح",
  "data": {
    "id": 13,
    "name": "تأمين السيارات",
    "active": true,
    "ads_count": 0,
    "created_at": "2024-01-15T22:00:00Z",
    "updated_at": "2024-01-15T22:00:00Z"
  }
}
```

#### 3.7.3 ✏️ تحديث نوع خدمة
**PUT** `/admin/car-service-types/{id}`

**الوصف:** تحديث نوع خدمة موجود

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Path Parameters:**
- `id` (required): معرف نوع الخدمة

**Body (JSON):**
```json
{
  "name": "تأمين وحماية السيارات",
  "active": true
}
```

**مثال على الطلب:**
```
PUT /api/admin/car-service-types/13
```

**مثال على الاستجابة:**
```json
{
  "message": "تم تحديث نوع الخدمة بنجاح",
  "data": {
    "id": 13,
    "name": "تأمين وحماية السيارات",
    "active": true,
    "ads_count": 0,
    "updated_at": "2024-01-15T22:15:00Z"
  }
}
```

#### 3.7.4 🗑️ حذف نوع خدمة
**DELETE** `/admin/car-service-types/{id}`

**الوصف:** حذف نوع خدمة (فقط إذا لم يكن مرتبط بأي إعلانات)

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Path Parameters:**
- `id` (required): معرف نوع الخدمة

**مثال على الطلب:**
```
DELETE /api/admin/car-service-types/13
```

**مثال على الاستجابة الناجحة:**
```json
{
  "message": "تم حذف نوع الخدمة بنجاح"
}
```

**مثال على خطأ (نوع مرتبط بإعلانات):**
```json
{
  "message": "لا يمكن حذف نوع الخدمة لأنه مرتبط بـ 5 إعلانات",
  "ads_count": 5
}
```

### 3.8 🎁 إدارة صندوق العروض
**GET** `/admin/offers-box/car-services`

**الوصف:** جلب جميع إعلانات الخدمات المفعلة في صندوق العروض

**Headers:**
```
Authorization: Bearer YOUR_ADMIN_TOKEN
Content-Type: application/json
```

**Query Parameters:**
- `status` (optional): حالة التفعيل ("active", "expired")
- `page` (optional): رقم الصفحة
- `per_page` (optional): عدد النتائج في الصفحة

**مثال على الطلب:**
```
GET /api/admin/offers-box/car-services?status=active
```

**مثال على الاستجابة:**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "ad_id": 15,
      "ad_title": "خدمة تغيير زيت السيارة المتميزة",
      "user_name": "أحمد محمد",
      "activated_at": "2024-01-15T18:00:00Z",
      "expires_at": "2024-01-22T18:00:00Z",
      "days": 7,
      "cost": "50.00",
      "status": "active"
    }
  ],
  "per_page": 20,
  "total": 8
}
```

---

## 4. أمثلة على سيناريوهات الاستخدام

### سيناريو 1: البحث عن خدمات غسيل السيارات في دبي
```
GET /api/car-services/search?emirate=Dubai&service_type=car_wash&sort_by=price_low
```

### سيناريو 2: إنشاء إعلان خدمة صيانة
```
POST /api/car-services-ads

Form Data:
title: ورشة صيانة شاملة
description: نقدم جميع خدمات الصيانة والإصلاح
emirate: Abu Dhabi
district: Al Khalidiyah
area: Corniche
service_type: general_maintenance
service_name: صيانة شاملة للسيارات
price: 300
main_image: [FILE]
```

### سيناريو 3: تفعيل إعلان في صندوق العروض
```
POST /api/offers-box/activate

{
  "category_slug": "car_services",
  "ad_id": 5,
  "days": 14
}
```

---

## 5. رموز الاستجابة (Response Codes)

- `200 OK`: العملية نجحت
- `201 Created`: تم إنشاء المورد بنجاح
- `204 No Content`: تم حذف المورد بنجاح
- `400 Bad Request`: خطأ في البيانات المرسلة
- `401 Unauthorized`: غير مصرح بالوصول
- `403 Forbidden`: ممنوع الوصول
- `404 Not Found`: المورد غير موجود
- `422 Unprocessable Entity`: خطأ في التحقق من صحة البيانات
- `500 Internal Server Error`: خطأ في الخادم

---

## 6. ملاحظات مهمة

1. **الصور**: يجب أن تكون الصور بصيغة (jpg, png, gif) وحجم أقصى 5MB
2. **المصادقة**: تأكد من إرسال Bearer Token في جميع العمليات المحمية
3. **الترقيم**: جميع الصفحات تبدأ من رقم 1
4. **الفلترة**: يمكن دمج عدة فلاتر في طلب واحد
5. **البحث**: البحث بالكلمات المفتاحية يشمل العنوان والوصف واسم الخدمة
6. **الترتيب**: الترتيب الافتراضي هو من الأحدث للأقدم

---

## 7. مجموعة Postman جاهزة للاستيراد

يمكنك إنشاء مجموعة Postman جديدة وإضافة جميع هذه الطلبات إليها لسهولة الاختبار والتطوير.

**اسم المجموعة:** Dubai Sale - Car Services API
**متغيرات البيئة:**
- `base_url`: http://localhost:8000/api
- `auth_token`: YOUR_BEARER_TOKEN_HERE
- `admin_token`: YOUR_ADMIN_TOKEN_HERE