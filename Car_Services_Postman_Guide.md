# دليل Postman الشامل لقسم خدمات السيارات (Car Services)

## نظرة عامة
هذا الدليل يغطي جميع API endpoints الخاصة بقسم خدمات السيارات في تطبيق Dubai Sale، مع أمثلة كاملة لاستخدام Postman.

## Base URL
```
http://localhost:8000/api
```

## المصادقة (Authentication)
معظم العمليات تتطلب Bearer Token:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 1. العمليات العامة (Public Endpoints)

### 1.1 الحصول على جميع إعلانات خدمات السيارات
**GET** `/car-services`

**الوصف:** جلب جميع إعلانات خدمات السيارات المعتمدة مع إمكانية الفلترة

**Query Parameters:**
- `service_type` (optional): نوع الخدمة
- `emirate` (optional): الإمارة
- `district` (optional): المنطقة
- `area` (optional): الحي
- `min_price` (optional): أقل سعر
- `max_price` (optional): أعلى سعر
- `page` (optional): رقم الصفحة

**مثال على الطلب:**
```
GET /api/car-services?service_type=oil_change&emirate=Dubai&page=1
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

### 1.2 البحث المتقدم في إعلانات خدمات السيارات
**GET** `/car-services/search`

**الوصف:** بحث متقدم مع فلترة وترتيب

**Query Parameters:**
- `emirate` (optional): الإمارة
- `service_type` (optional): نوع الخدمة
- `district` (optional): المنطقة
- `area` (optional): الحي
- `min_price` (optional): أقل سعر
- `max_price` (optional): أعلى سعر
- `keyword` (optional): كلمة مفتاحية للبحث
- `sort_by` (optional): `latest`, `price_low`, `price_high`, `most_viewed`
- `per_page` (optional): عدد النتائج في الصفحة (1-50)

**مثال على الطلب:**
```
GET /api/car-services/search?emirate=Dubai&service_type=car_wash&keyword=تنظيف&sort_by=price_low&per_page=10
```

### 1.3 الحصول على بيانات الفلاتر
**GET** `/car-services/filters`

**الوصف:** جلب جميع الخيارات المتاحة للفلترة

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

### 1.4 عرض إعلان خدمة محدد
**GET** `/car-services/{id}`

**الوصف:** جلب تفاصيل إعلان خدمة محدد

**مثال على الطلب:**
```
GET /api/car-services/1
```

### 1.5 الحصول على إعلانات صندوق العروض
**GET** `/car-services/offers-box/ads`

**الوصف:** جلب إعلانات خدمات السيارات من صندوق العروض

**Query Parameters:**
- `limit` (optional): عدد الإعلانات (افتراضي: 10)

**مثال على الطلب:**
```
GET /api/car-services/offers-box/ads?limit=5
```

### 1.6 الحصول على أنواع الخدمات
**GET** `/car-service-types`

**الوصف:** جلب جميع أنواع خدمات السيارات النشطة

**مثال على الطلب:**
```
GET /api/car-service-types
```

---

## 2. العمليات المحمية (Authenticated Endpoints)

### 2.1 إنشاء إعلان خدمة جديد
**POST** `/car-services-ads`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Content-Type: multipart/form-data
```

**Body (Form Data):**
- `title` (required): عنوان الإعلان
- `description` (required): وصف الخدمة
- `emirate` (required): الإمارة
- `district` (required): المنطقة
- `area` (required): الحي
- `service_type` (required): نوع الخدمة
- `service_name` (required): اسم الخدمة
- `price` (required): السعر
- `location` (optional): الموقع التفصيلي
- `main_image` (required): الصورة الأساسية (ملف)
- `thumbnail_images[]` (optional): صور إضافية (ملفات)

**مثال على الطلب:**
```
POST /api/car-services-ads

Form Data:
title: خدمة تغيير زيت السيارة
description: نقدم خدمة تغيير زيت عالية الجودة لجميع أنواع السيارات
emirate: Dubai
district: Deira
area: Al Rigga
service_type: oil_change
service_name: تغيير زيت المحرك
price: 150
location: بالقرب من مترو الاتحاد
main_image: [FILE]
thumbnail_images[]: [FILE1]
thumbnail_images[]: [FILE2]
```

### 2.2 تحديث إعلان خدمة
**PUT** `/car-services-ads/{id}`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Content-Type: multipart/form-data
```

**Body:** نفس حقول الإنشاء ولكن جميعها اختيارية

### 2.3 حذف إعلان خدمة
**DELETE** `/car-services-ads/{id}`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**مثال على الطلب:**
```
DELETE /api/car-services-ads/1
```

### 2.4 الحصول على إعلانات المستخدم
**GET** `/my-ads`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**الوصف:** جلب جميع إعلانات المستخدم (سيارات وخدمات)

### 2.5 تفعيل صندوق العروض
**POST** `/offers-box/activate`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json
```

**Body:**
```json
{
  "category_slug": "car_services",
  "ad_id": 1,
  "days": 7
}
```

---

## 3. عمليات الإدارة (Admin Endpoints)

### 3.1 الحصول على جميع إعلانات الخدمات للإدارة
**GET** `/admin/car-services-ads`

**Headers:**
```
Authorization: Bearer ADMIN_TOKEN
```

**Query Parameters:**
- `status` (optional): حالة الإعلان (`Valid`, `Pending`, `Rejected`)
- `approved` (optional): حالة الموافقة (`true`, `false`)

**مثال على الطلب:**
```
GET /api/admin/car-services-ads?status=Pending&approved=false
```

### 3.2 الموافقة على إعلان خدمة
**POST** `/admin/car-services-ads/{id}/approve`

**Headers:**
```
Authorization: Bearer ADMIN_TOKEN
```

**مثال على الطلب:**
```
POST /api/admin/car-services-ads/1/approve
```

### 3.3 رفض إعلان خدمة
**POST** `/admin/car-services-ads/{id}/reject`

**Headers:**
```
Authorization: Bearer ADMIN_TOKEN
```

**مثال على الطلب:**
```
POST /api/admin/car-services-ads/1/reject
```

### 3.4 إدارة أنواع الخدمات
**GET** `/admin/car-service-types` - جلب جميع أنواع الخدمات
**POST** `/admin/car-service-types` - إنشاء نوع خدمة جديد
**PUT** `/admin/car-service-types/{id}` - تحديث نوع خدمة
**DELETE** `/admin/car-service-types/{id}` - حذف نوع خدمة
**POST** `/admin/car-service-types/bulk-update` - تحديث مجمع
**POST** `/admin/car-service-types/{id}/toggle-active` - تفعيل/إلغاء تفعيل

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