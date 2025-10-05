# توثيق تسجيل الدخول والتحقق (OTP)

هذا المستند يشرح سيناريوهات تسجيل الدخول والتحقق للمستخدمين (Guests و Advertisers) بعد تعديلات الباك إند.

## نظرة عامة على المسارات
- `POST /api/newSignin`: تسجيل دخول أولي بالهاتف. المستخدم الجديد يصبح `guest` ولا يُرسل له OTP. المعلن الحالي يحصل على OTP.
- `POST /api/request-otp`: طلب OTP بشكل آمن باستخدام رقم الهاتف. يخدم الضيوف الراغبين في التحول إلى معلنين، والمعلنين الحاليين الراغبين في تسجيل الدخول.
- `PUT /api/verify`: التحقق من OTP. يحدّث المستخدم إلى `advertiser` عند الحاجة ويُصدر توكين.
- `POST /api/resend-otp`: إعادة إرسال OTP (خاضع لمهلة 60 ثانية). مخصص للمعلنين.
- `POST /api/login`: دخول بكلمة مرور للمشرفين فقط.

ملاحظات أمان:
- تم تعطيل/إزالة المسار القديم غير الآمن `POST /convert-to-advertiser/{id}`.
- دخول كلمة المرور مقيّد للمشرفين فقط.
- يسمح النظام بتعدد الجلسات للمستخدم نفسه دون حذف التوكينات القديمة.

مهلة وإعدادات OTP:
- صلاحية الـ OTP: 10 دقائق.
- مهلة بين طلبات OTP: 60 ثانية.

## السيناريوهات التفصيلية

### 1) مستخدم جديد تمامًا
- الوصف: شخص يُدخل رقم هاتفه لأول مرة وغير موجود في النظام.
- الخطوات: يستدعي `POST /api/newSignin` مع الحقل `phone`.
- النتيجة المتوقعة:
  - يتم إنشاء حساب من النوع `guest`.
  - لا يتم إرسال OTP.
  - تُعاد رسالة نجاح توضح إنشاء الحساب كضيف.

### 2) مستخدم "ضيف" (Guest) حالي
- الوصف: مستخدم `guest` موجود مسبقًا يُدخل رقم هاتفه.
- الخطوات: يستدعي `POST /api/newSignin` مع الحقل `phone`.
- النتيجة المتوقعة:
  - يتلقى رسالة ترحيب تؤكد أنه مستخدم ضيف.
  - لا يتم إرسال OTP.

### 3) "ضيف" يرغب في إضافة إعلان (التحول إلى معلن)
- الوصف: مستخدم `guest` يريد التحول إلى `advertiser`.
- الخطوات من جهة التطبيق:
  1. يستدعي `POST /api/request-otp` مع `phone` لطلب OTP.
  2. بعد إدخال الكود الصحيح، يستدعي `PUT /api/verify` مع `phone` و`otp`.
- النتيجة المتوقعة:
  - يتم تحديث نوع المستخدم إلى `advertiser`.
  - يتم إصدار توكين (`Sanctum token`).
  - يستطيع تنفيذ عمليات محمية للمعلنين.

### 4) "معلن" حالي يقوم بتسجيل الدخول
- الوصف: مستخدم `advertiser` موجود مسبقًا يُدخل رقم هاتفه.
- الخطوات:
  1. يستدعي `POST /api/newSignin` أو `POST /api/request-otp` لإرسال OTP.
  2. يتحقق عبر `PUT /api/verify` بإدخال `otp` الصحيح.
- النتيجة المتوقعة:
  - يحصل على توكين جديد ويسجل الدخول بنجاح.

### 5) إعادة إرسال كود التحقق (OTP)
- الوصف: إعادة إرسال OTP مع مهلة زمنية لمنع الإساءة.
- الخطوات: يستدعي `POST /api/resend-otp` مع `phone`.
- القيود:
  - متاح للمستخدمين من نوع `advertiser`.
  - لا يمكن الإرسال إذا لم تمضِ 60 ثانية منذ آخر طلب.
- النتيجة المتوقعة:
  - يُرسل OTP جديد مع صلاحية 10 دقائق.

## ملخص الاستجابات المتوقعة
- نجاح طلب OTP: كائن JSON يحوي `message` و`expires_in` (ثواني حتى انتهاء الـ OTP).
- فشل التحقق أو عدم استحقاق: `403` أو `422` مع رسالة توضيحية.
- مهلة معدل الطلب: `429` برسالة تفيد بضرورة الانتظار.
- مستخدم غير موجود لـ `request-otp`: `404` يطلب التسجيل أولًا عبر `newSignin`.

## ملاحظات إضافية للمطورين
- يتم حماية مسارات المعلنين عبر وسائط: `auth:sanctum`, `EnsureUserIsVerified`, و`EnsureUserIsAdvertiser`.
- لا يتم حذف التوكينات القديمة عند النجاح في التحقق؛ يسمح بتعدد الجلسات.
- `POST /api/login` مخصص للمشرفين (`role = admin`) فقط.

## أمثلة JSON سريعة
ملاحظة: الأمثلة التالية توضيحية وقد تختلف صياغة الرسائل قليلًا حسب الإصدار.

- مثال 1: مستخدم جديد تمامًا (POST `/api/newSignin`)
  - Request Body:
    ```json
    {
      "phone": "+971500000000"
    }
    ```
  - Response Body (200):
    ```json
    {
      "message": "Signed in as guest"
    }
    ```

- مثال 2: مستخدم Guest حالي (POST `/api/newSignin`)
  - Request Body:
    ```json
    {
      "phone": "+971500000000"
    }
    ```
  - Response Body (200):
    ```json
    {
      "message": "Welcome back, guest user"
    }
    ```

- مثال 3: Guest يريد التحول إلى Advertiser
  - خطوة الطلب (POST `/api/request-otp`)
    - Request Body:
      ```json
      {
        "phone": "+971500000000"
      }
      ```
    - Response Body (200):
      ```json
      {
        "message": "OTP has been sent. Verify to convert your account to advertiser.",
        "expires_in": 600
      }
      ```
  - خطوة التحقق (PUT `/api/verify`)
    - Request Body:
      ```json
      {
        "phone": "+971500000000",
        "otp": "3457"
      }
      ```
    - Response Body (200):
      ```json
      {
        "message": "Verification successful",
        "user_type": "advertiser",
        "otp_verified": true,
        "token": "<sanctum_plain_text_token>"
      }
      ```

- مثال 4: Advertiser حالي يقوم بتسجيل الدخول عبر OTP
  - خطوة الطلب (POST `/api/request-otp`)
    - Request Body:
      ```json
      {
        "phone": "+971511111111"
      }
      ```
    - Response Body (200):
      ```json
      {
        "message": "OTP has been sent. Verify to login as advertiser.",
        "expires_in": 600
      }
      ```
  - خطوة التحقق (PUT `/api/verify`)
    - Request Body:
      ```json
      {
        "phone": "+971511111111",
        "otp": "3457"
      }
      ```
    - Response Body (200):
      ```json
      {
        "message": "Verification successful",
        "token": "<sanctum_plain_text_token>"
      }
      ```

- مثال 5: إعادة إرسال OTP (POST `/api/resend-otp`)
  - Request Body:
    ```json
    {
      "phone": "+971511111111"
    }
    ```
  - Response Body (200):
    ```json
    {
      "message": "OTP resent successfully",
      "expires_in": 600
    }
    ```

- أمثلة أخطاء شائعة
  - Rate limit (429) لطلب أو إعادة إرسال OTP:
    ```json
    {
      "message": "Please wait before requesting another OTP."
    }
    ```
  - مستخدم غير موجود لـ `/api/request-otp` (404):
    ```json
    {
      "message": "User not found. Please sign up first via /newSignin."
    }
    ```
  - محاولة دخول بكلمة مرور لمستخدم غير Admin (403):
    ```json
    {
      "message": "Access denied. Password login is restricted to admins only."
    }
    ```