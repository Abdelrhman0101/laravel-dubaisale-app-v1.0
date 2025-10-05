# 🍽️ دليل Postman الشامل لقسم المطاعم (Restaurants)

## 📋 نظرة عامة
هذا الدليل يغطي جميع API endpoints الخاصة بقسم المطاعم في تطبيق Dubai Sale، بما في ذلك الاستعراض العام، عرض إعلان محدد، وعمليات الإنشاء/التحديث/الحذف للمستخدمين الموثقين.

## 🌐 Base URL
```
http://localhost:8000/api
```

## 🔐 المصادقة (Authentication)
- للمستخدمين العاديين (للعمليات المحمية فقط):
```
Authorization: Bearer YOUR_USER_TOKEN_HERE
```
- جميع عمليات القراءة العامة لا تتطلب توكن.

---
# 👥 القسم الأول: API للمستخدمين (عام — Public)

### 1.1 📋 الحصول على جميع إعلانات المطاعم
**GET** `/restaurants`

**الوصف:** جلب جميع إعلانات المطاعم المعتمدة والنشطة مع إمكانية الفلترة والترتيب

**Headers:**
```
Content-Type: application/json
```

**Query Parameters:**
- `emirate` (optional): الإمارة (Dubai, Abu Dhabi, ...)
- `district` (optional): المنطقة
- `area` (optional): الحي
- `price_range` (optional): نطاق السعر كنص (مثال: "50-100", "budget", "premium")
- `sort` (optional): نوع الترتيب — `latest` (افتراضي) أو `most_viewed` أو `rank`
- `per_page` (optional): عدد النتائج في الصفحة (افتراضي: 15)
- `page` (optional): رقم الصفحة (افتراضي: 1)

**أمثلة:**
```
GET /api/restaurants
GET /api/restaurants?emirate=Dubai&district=Deira&sort=most_viewed
GET /api/restaurants?price_range=50-100&per_page=20&page=2
```

**مثال على الاستجابة (مختصر):**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 12,
      "title": "مطعم مأكولات بحرية",
      "description": "أطباق بحرية طازجة يومياً",
      "emirate": "Dubai",
      "district": "Deira",
      "area": "Al Rigga",
      "price_range": "50-100",
      "advertiser_name": "Seafood LLC",
      "phone_number": "+971501234567",
      "whatsapp_number": "+971501234567",
      "main_image_url": "http://localhost:8000/storage/restaurants/main/12.jpg",
      "thumbnail_images_urls": [],
      "views": 34,
      "status": "Valid",
      "category": "Restaurants"
    }
  ],
  "per_page": 15,
  "total": 1
}
```

### 1.2 👁️ عرض إعلان مطعم محدد
**GET** `/restaurants/{id}`

**الوصف:** جلب تفاصيل إعلان مطعم محدد مع زيادة عداد المشاهدات تلقائياً

**Headers:**
```
Content-Type: application/json
```

**أمثلة:**
```
GET /api/restaurants/12
```

**مثال على الاستجابة (مختصر):**
```json
{
  "id": 12,
  "title": "مطعم مأكولات بحرية",
  "description": "أطباق بحرية طازجة يومياً",
  "emirate": "Dubai",
  "district": "Deira",
  "area": "Al Rigga",
  "price_range": "50-100",
  "advertiser_name": "Seafood LLC",
  "phone_number": "+971501234567",
  "whatsapp_number": "+971501234567",
  "main_image_url": "http://localhost:8000/storage/restaurants/main/12.jpg",
  "thumbnail_images_urls": [],
  "views": 35,
  "status": "Valid",
  "category": "Restaurants"
}
```

---
# 🔐 القسم الثاني: العمليات المحمية (Authenticated)

> يجب إرسال توكن المستخدم في كل الطلبات التالية:
```
Authorization: Bearer YOUR_USER_TOKEN
```

### 2.1 ➕ إنشاء إعلان مطعم جديد
**POST** `/restaurants`

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: multipart/form-data
```

**Body (Form Data):**
- `title` (required): عنوان الإعلان
- `description` (required): وصف المطعم/العرض
- `emirate` (required): الإمارة
- `district` (required): المنطقة
- `area` (optional): الحي
- `price_range` (required): نطاق السعر (نصي)
- `main_image` (required): الصورة الأساسية (ملف: jpg/png/gif، max 5MB)
- `thumbnail_images[]` (optional): صور إضافية (ملفات، حتى عدة صور، كل صورة max 5MB)
- `advertiser_name` (required): اسم المعلن
- `whatsapp_number` (required): رقم واتساب (نصي، max 20)
- `phone_number` (optional): رقم هاتف (نصي، max 20)
- `address` (required): العنوان التفصيلي (حتى 500 حرف)
- حقول الخطة (اختياري): `plan_type`، `plan_days`، `plan_expires_at`

**استجابة ناجحة (201 مثال مختصر):**
```json
{
  "id": 25,
  "title": "مطعم بيتزا الإيطالي",
  "emirate": "Dubai",
  "district": "Jumeirah",
  "price_range": "budget",
  "main_image_url": "http://localhost:8000/storage/restaurants/main/25.jpg",
  "thumbnail_images_urls": [],
  "status": "Pending",
  "category": "Restaurants"
}
```

### 2.2 ✏️ تحديث إعلان مطعم
**PUT/PATCH** `/restaurants/{id}`

- جميع الحقول اختيارية (يتم تحديث المرسل فقط)
- يمكن استبدال الصورة الأساسية والـ thumbnails بإرسال ملفات جديدة

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: multipart/form-data
```

**أمثلة (تحديث السعر والوصف فقط):**
```
PUT /api/restaurants/25
Body: price_range=mid-range, description=قائمة جديدة وعرض غداء
```

**استجابة (مختصر):**
```json
{
  "id": 25,
  "price_range": "mid-range",
  "description": "قائمة جديدة وعرض غداء"
}
```

### 2.3 🗑️ حذف إعلان مطعم
**DELETE** `/restaurants/{id}`

**Headers:**
```
Authorization: Bearer YOUR_USER_TOKEN
Content-Type: application/json
```

**أمثلة:**
```
DELETE /api/restaurants/25
```

**استجابة ناجحة:**
```json
{
}
```

---
## 📝 ملاحظات مهمة
- يتم نشر الإعلانات تلقائياً كـ "Pending" إذا كان وضع الموافقة اليدوي مفعّلاً في النظام، وإلا ستُنشر "Valid" فوراً.
- يتم احتساب المشاهدات تلقائياً عند عرض إعلان محدد.
- صندوق العروض (Offers Box) غير مفعّل حالياً لقسم المطاعم.