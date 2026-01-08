# دليل استخدام نظام الإبلاغ عن الإعلانات (Ad Reports)

## 📌 نظرة عامة

نظام الإبلاغ عن الإعلانات يسمح للمستخدمين بالإبلاغ عن أي إعلان مخالف أو غير مناسب. يتم مراجعة هذه البلاغات من قبل الإدارة واتخاذ الإجراء المناسب.

---

## 🔧 الإعداد الأولي

### 1. تشغيل Migration
```bash
php artisan migrate
```

---

## 📋 Endpoints المتاحة

### **القسم العام (Public Routes)**

#### 1️⃣ الحصول على أسباب الإبلاغ المتاحة
```
GET /api/reports/reasons
```

**Response:**
```json
{
  "success": true,
  "data": {
    "inappropriate": "محتوى غير لائق",
    "spam": "إعلان مزعج أو تكراري",
    "misleading": "معلومات مضللة",
    "duplicate": "إعلان مكرر",
    "fraud": "احتيال أو نصب",
    "wrong_category": "قسم خاطئ",
    "other": "أخرى"
  }
}
```

---

#### 2️⃣ الحصول على أنواع الإعلانات المتاحة
```
GET /api/reports/ad-types
```

**Response:**
```json
{
  "success": true,
  "data": [
    "car_sale",
    "car_rent",
    "car_service",
    "restaurant",
    "job",
    "real_estate",
    "electronic",
    "other_service"
  ]
}
```

---

#### 3️⃣ إرسال بلاغ جديد (متاح للجميع - حتى بدون تسجيل دخول)
```
POST /api/reports
```

**Request Headers:**
```
Content-Type: application/json
Authorization: Bearer {token}  // اختياري - إذا كان المستخدم مسجل دخول
```

**Request Body:**
```json
{
  "ad_type": "car_sale",
  "ad_id": 123,
  "reason": "spam",
  "description": "هذا الإعلان مكرر عدة مرات من نفس المعلن"
}
```

**Request Body Parameters:**
| Parameter | Type | Required | Description | Values |
|-----------|------|----------|-------------|---------|
| ad_type | string | ✅ Yes | نوع الإعلان | car_sale, car_rent, car_service, restaurant, job, real_estate, electronic, other_service |
| ad_id | integer | ✅ Yes | معرف الإعلان | رقم موجب |
| reason | string | ✅ Yes | سبب البلاغ | inappropriate, spam, misleading, duplicate, fraud, wrong_category, other |
| description | string | ❌ No | وصف تفصيلي (اختياري) | نص لا يتجاوز 1000 حرف |

**Success Response (201):**
```json
{
  "success": true,
  "message": "تم إرسال البلاغ بنجاح. سيتم مراجعته في أقرب وقت.",
  "data": {
    "report_id": 1,
    "status": "pending",
    "created_at": "2026-01-08 20:45:30"
  }
}
```

**Error Response (422):**
```json
{
  "success": false,
  "message": "خطأ في البيانات المدخلة",
  "errors": {
    "ad_type": ["نوع الإعلان مطلوب"],
    "reason": ["سبب البلاغ غير صحيح"]
  }
}
```

**Error Response (404):**
```json
{
  "success": false,
  "message": "الإعلان المحدد غير موجود"
}
```

---

### **قسم المستخدم المسجل (Authenticated User Routes)**

#### 4️⃣ عرض بلاغات المستخدم الحالي
```
GET /api/reports/my-reports
```

**Request Headers:**
```
Authorization: Bearer {token}  // مطلوب
```

**Query Parameters (Optional):**
| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| per_page | integer | عدد النتائج في الصفحة | ?per_page=20 |
| status | string | تصفية حسب الحالة | ?status=pending |
| page | integer | رقم الصفحة | ?page=2 |

**Response:**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "ad_type": "car_sale",
        "ad_id": 123,
        "reason": "spam",
        "reason_text": "إعلان مزعج أو تكراري",
        "description": "هذا الإعلان مكرر عدة مرات",
        "status": "pending",
        "admin_note": null,
        "reviewed_by": null,
        "reviewed_at": null,
        "created_at": "2026-01-08 20:45:30"
      },
      {
        "id": 2,
        "ad_type": "restaurant",
        "ad_id": 456,
        "reason": "inappropriate",
        "reason_text": "محتوى غير لائق",
        "description": "صور غير مناسبة",
        "status": "resolved",
        "admin_note": "تم حذف الإعلان",
        "reviewed_by": {
          "id": 5,
          "name": "أحمد محمد"
        },
        "reviewed_at": "2026-01-08 21:00:00",
        "created_at": "2026-01-08 19:30:00"
      }
    ],
    "per_page": 15,
    "total": 2
  }
}
```

---

### **قسم الإدارة (Admin Routes)**

**جميع routes الإدارة تتطلب:**
```
Authorization: Bearer {admin_token}
```

#### 5️⃣ عرض جميع البلاغات (للأدمن)
```
GET /api/admin/reports
```

**Query Parameters (Optional):**
| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| per_page | integer | عدد النتائج في الصفحة | ?per_page=20 |
| status | string | تصفية حسب الحالة | ?status=pending |
| ad_type | string | تصفية حسب نوع الإعلان | ?ad_type=car_sale |
| reason | string | تصفية حسب السبب | ?reason=spam |
| page | integer | رقم الصفحة | ?page=2 |

**Response:**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "reporter": {
          "id": 10,
          "name": "علي أحمد",
          "phone": "0501234567"
        },
        "ad_type": "car_sale",
        "ad_id": 123,
        "reason": "spam",
        "reason_text": "إعلان مزعج أو تكراري",
        "description": "هذا الإعلان مكرر عدة مرات",
        "status": "pending",
        "admin_note": null,
        "reviewed_by": null,
        "reviewed_at": null,
        "created_at": "2026-01-08 20:45:30"
      }
    ],
    "per_page": 15,
    "total": 25
  }
}
```

---

#### 6️⃣ عرض تفاصيل بلاغ محدد (للأدمن)
```
GET /api/admin/reports/{report_id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "reporter": {
      "id": 10,
      "name": "علي أحمد",
      "phone": "0501234567",
      "email": "ali@example.com"
    },
    "ad_type": "car_sale",
    "ad_id": 123,
    "ad_details": {
      "id": 123,
      "title": "تويوتا كامري 2020",
      "description": "سيارة نظيفة جداً...",
      "status": "active",
      "created_at": "2026-01-05 10:00:00"
    },
    "reason": "spam",
    "reason_text": "إعلان مزعج أو تكراري",
    "description": "هذا الإعلان مكرر عدة مرات من نفس المعلن",
    "status": "pending",
    "admin_note": null,
    "reviewed_by": null,
    "reviewed_at": null,
    "created_at": "2026-01-08 20:45:30",
    "updated_at": "2026-01-08 20:45:30"
  }
}
```

---

#### 7️⃣ تحديث حالة البلاغ (للأدمن)
```
PUT /api/admin/reports/{report_id}
```

**Request Body:**
```json
{
  "status": "resolved",
  "admin_note": "تم حذف الإعلان المخالف وإيقاف حساب المعلن مؤقتاً"
}
```

**Request Body Parameters:**
| Parameter | Type | Required | Description | Values |
|-----------|------|----------|-------------|---------|
| status | string | ✅ Yes | الحالة الجديدة | pending, reviewed, resolved, rejected |
| admin_note | string | ❌ No | ملاحظة الإدارة | نص لا يتجاوز 1000 حرف |

**Response:**
```json
{
  "success": true,
  "message": "تم تحديث البلاغ بنجاح",
  "data": {
    "id": 1,
    "status": "resolved",
    "admin_note": "تم حذف الإعلان المخالف وإيقاف حساب المعلن مؤقتاً",
    "reviewed_at": "2026-01-08 21:30:00"
  }
}
```

---

#### 8️⃣ حذف بلاغ (للأدمن)
```
DELETE /api/admin/reports/{report_id}
```

**Response:**
```json
{
  "success": true,
  "message": "تم حذف البلاغ بنجاح"
}
```

---

#### 9️⃣ إحصائيات البلاغات (للأدمن)
```
GET /api/admin/reports/stats
```

**Response:**
```json
{
  "success": true,
  "data": {
    "total": 125,
    "pending": 45,
    "reviewed": 20,
    "resolved": 50,
    "rejected": 10,
    "by_reason": {
      "spam": 40,
      "inappropriate": 30,
      "misleading": 25,
      "duplicate": 15,
      "fraud": 10,
      "wrong_category": 3,
      "other": 2
    },
    "by_ad_type": {
      "car_sale": 50,
      "restaurant": 30,
      "real_estate": 25,
      "job": 10,
      "car_rent": 5,
      "electronic": 3,
      "car_service": 1,
      "other_service": 1
    }
  }
}
```

---

## 📊 حالات البلاغ (Status)

| Status | الوصف |
|--------|-------|
| `pending` | معلق - في انتظار المراجعة |
| `reviewed` | تمت المراجعة |
| `resolved` | تم الحل - تم اتخاذ الإجراء المناسب |
| `rejected` | تم الرفض - البلاغ غير صحيح |

---

## 🎯 أمثلة عملية

### مثال 1: إبلاغ عن إعلان سيارة
```bash
curl -X POST "https://example.com/api/reports" \
  -H "Content-Type: application/json" \
  -d '{
    "ad_type": "car_sale",
    "ad_id": 123,
    "reason": "spam",
    "description": "المعلن ينشر نفس الإعلان يومياً"
  }'
```

### مثال 2: إبلاغ من مستخدم مسجل
```bash
curl -X POST "https://example.com/api/reports" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {user_token}" \
  -d '{
    "ad_type": "restaurant",
    "ad_id": 456,
    "reason": "inappropriate",
    "description": "صور غير لائقة في الإعلان"
  }'
```

### مثال 3: عرض بلاغاتي
```bash
curl -X GET "https://example.com/api/reports/my-reports?status=pending" \
  -H "Authorization: Bearer {user_token}"
```

### مثال 4: الأدمن يحدث حالة البلاغ
```bash
curl -X PUT "https://example.com/api/admin/reports/1" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {admin_token}" \
  -d '{
    "status": "resolved",
    "admin_note": "تم حذف الإعلان وتحذير المعلن"
  }'
```

---

## 🔒 الصلاحيات

| Endpoint | الوصول |
|----------|--------|
| `POST /api/reports` | الجميع (حتى بدون تسجيل) |
| `GET /api/reports/reasons` | الجميع |
| `GET /api/reports/ad-types` | الجميع |
| `GET /api/reports/my-reports` | مستخدم مسجل فقط |
| `GET /api/admin/reports` | أدمن فقط |
| `GET /api/admin/reports/{id}` | أدمن فقط |
| `PUT /api/admin/reports/{id}` | أدمن فقط |
| `DELETE /api/admin/reports/{id}` | أدمن فقط |
| `GET /api/admin/reports/stats` | أدمن فقط |

---

## ⚠️ ملاحظات مهمة

1. **التحقق من الإعلان**: يتم التحقق تلقائياً من وجود الإعلان قبل قبول البلاغ
2. **المستخدمين الغير مسجلين**: يمكنهم الإبلاغ لكن `user_id` سيكون `null`
3. **التكرار**: لا يوجد حالياً منع للتكرار - يمكن للمستخدم الإبلاغ عن نفس الإعلان أكثر من مرة
4. **الإشعارات**: النظام لا يرسل إشعارات تلقائياً - يمكن إضافة ذلك لاحقاً
5. **Pagination**: جميع القوائم تدعم الـ pagination

---

## 🚀 التطوير المستقبلي

يمكن إضافة الميزات التالية مستقبلاً:
- ✨ إشعارات تلقائية للمُبلغ عند تحديث حالة البلاغ
- ✨ منع التكرار (نفس المستخدم لا يمكنه الإبلاغ عن نفس الإعلان مرتين)
- ✨ تقييم البلاغات (مفيد/غير مفيد)
- ✨ إحصائيات متقدمة للأدمن
- ✨ نظام نقاط للمُبلغين الصادقين

---

## 📞 الدعم الفني

في حالة وجود أي مشاكل أو استفسارات، يرجى التواصل مع فريق التطوير.

---

**آخر تحديث:** 2026-01-08
