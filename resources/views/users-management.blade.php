@extends('layouts.dashboard')

@section('title', 'إدارة المستخدمين - User Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1 text-primary fw-bold">
                                <i class="bi bi-people-fill me-2"></i>
                                إدارة المستخدمين
                                <small class="text-muted fs-6">User Management</small>
                            </h2>
                            <p class="text-muted mb-0">إدارة وعرض جميع المستخدمين المسجلين في النظام</p>
                            <small class="text-muted">Manage and view all registered users in the system</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary fs-6 px-3 py-2">
                                {{ $users->count() }} مستخدم
                                <br><small>Users</small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-funnel-fill me-2 text-primary"></i>
                        فلترة المستخدمين
                        <small class="text-muted">Filter Users</small>
                    </h5>
                    <div class="btn-group" role="group">
                        <a href="{{ route('users-management', ['filter' => 'all']) }}" 
                           class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-people me-1"></i>
                            الكل
                            <br><small>All</small>
                        </a>
                        <a href="{{ route('users-management', ['filter' => 'advertisers']) }}" 
                           class="btn {{ $filter === 'advertisers' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-megaphone me-1"></i>
                            المعلنين
                            <br><small>Advertisers</small>
                        </a>
                        <a href="{{ route('users-management', ['filter' => 'visitors']) }}" 
                           class="btn {{ $filter === 'visitors' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-eye me-1"></i>
                            الزوار
                            <br><small>Visitors</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 text-primary">
                        <i class="bi bi-table me-2"></i>
                        قائمة المستخدمين
                        <small class="text-muted">Users List</small>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="border-0 px-4 py-3">
                                        <strong class="d-block fs-6">الاسم</strong>
                                        <small class="text-white-50 fw-normal">Name</small>
                                    </th>
                                    <th class="border-0 px-4 py-3">
                                        <strong class="d-block fs-6">رقم التليفون</strong>
                                        <small class="text-white-50 fw-normal">Phone Number</small>
                                    </th>
                                    <th class="border-0 px-4 py-3">
                                        <strong class="d-block fs-6">الايميل</strong>
                                        <small class="text-white-50 fw-normal">Email</small>
                                    </th>
                                    <th class="border-0 px-4 py-3">
                                        <div class="d-block fs-6 fw-bold">عدد الاعلانات</div>
                                        <div class="text-white-50 fw-normal">Num of Ads</div>
                                    </th>
                                    <th class="border-0 px-4 py-3">
                                        <div class="d-block fs-6 fw-bold">سجل من خلاله</div>
                                        <div class="text-white-50 fw-normal">Reg Through</div>
                                    </th>
                                    <th class="border-0 px-4 py-3 text-center">
                                        <strong class="d-block fs-6">الاجراءات</strong>
                                        <small class="text-white-50 fw-normal">Actions</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">
                                        <div>
                                            <strong class="text-dark">{{ $user->name }}</strong>
                                            <br>
                                            <span class="badge bg-{{ $user->user_type === 'normal_user' ? 'secondary' : 'success' }} small">
                                                {{ $user->user_type === 'normal_user' ? 'زائر' : 'معلن' }}
                                                <br><small>{{ $user->user_type === 'normal_user' ? 'Visitor' : 'Advertiser' }}</small>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-dark">{{ $user->phone ?? 'غير محدد' }}</span>
                                        <br><small class="text-muted">{{ $user->phone ? '' : 'Not specified' }}</small>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-dark">{{ $user->email }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge {{ $user->ads_count > 0 ? 'bg-info' : 'bg-secondary' }} text-white px-3 py-2">
                                            {{ $user->ads_count }} إعلان
                                            <br><small>Ads</small>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            {{ $user->registration_method }}
                                            <br><small>{{ $user->registration_method_en }}</small>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('user-details', $user->id) }}" 
                                               class="btn btn-primary btn-sm px-2 py-1" title="عرض البيانات - View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button class="btn btn-info btn-sm px-2 py-1" 
                                                    onclick="openPackagesModal({{ $user->id }})"
                                                    title="الباقات - Packages">
                                                <i class="bi bi-box-seam"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm px-2 py-1" 
                                                    onclick="blockUser({{ $user->id }})"
                                                    title="حظر المستخدم - Block User">
                                                <i class="bi bi-ban"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm px-2 py-1" 
                                                    onclick="deleteUser({{ $user->id }})" 
                                                    title="حذف المستخدم - Delete User">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                            <h5>لا توجد مستخدمين</h5>
                                            <p>No users found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Packages Modal -->
<div class="modal fade" id="packagesModal" tabindex="-1" aria-labelledby="packagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="packagesModalLabel">
                    <i class="bi bi-box-seam me-2"></i>
                    الباقات - Packages
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="border-0 px-4 py-3">
                                    <strong>البيانات - Data</strong>
                                </th>
                                <th class="border-0 px-4 py-3 text-center">
                                    <strong>مميزة - Featured</strong>
                                </th>
                                <th class="border-0 px-4 py-3 text-center">
                                    <strong>بريميوم - Premium</strong>
                                </th>
                                <th class="border-0 px-4 py-3 text-center">
                                    <strong>بريميوم ستار - Premium Star</strong>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-bottom">
                                <td class="px-4 py-3">
                                    <strong class="text-dark">عدد الإعلانات - Number of Ads</strong>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="featured_ads" value="10" min="1">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="premium_ads" value="25" min="1">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="premium_star_ads" value="50" min="1">
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="px-4 py-3">
                                    <strong class="text-dark">السعر - Price</strong>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="featured_price" value="50" min="0" step="0.01">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="premium_price" value="100" min="0" step="0.01">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="premium_star_price" value="200" min="0" step="0.01">
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <td class="px-4 py-3">
                                    <strong class="text-dark">مدة الصلاحية (أيام) - Validity (Days)</strong>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="featured_days" value="30" min="1">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="premium_days" value="60" min="1">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" class="form-control text-center" id="premium_star_days" value="90" min="1">
                                </td>
                            </tr>
                            <!-- <tr class="border-bottom">
                                <td class="px-4 py-3">
                                    <strong class="text-dark">تاريخ النشر - Publication Date</strong>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="date" class="form-control text-center" id="featured_date" value="{{ date('Y-m-d') }}">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="date" class="form-control text-center" id="premium_date" value="{{ date('Y-m-d') }}">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="date" class="form-control text-center" id="premium_star_date" value="{{ date('Y-m-d') }}">
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    إغلاق - Close
                </button>
                <button type="button" class="btn btn-primary" onclick="saveAllPackages()">
                    <i class="bi bi-save me-1"></i>
                    حفظ جميع الباقات - Save All Packages
                </button>
            </div>
        </div>
    </div>
</div>

<style>


.card {
    border-radius: 12px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.table th {
    font-weight: 600;
    color: var(--primary-blue);
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
}

.badge {
    border-radius: 6px;
    font-weight: 500;
}

.btn-group .btn {
    min-width: 120px;
    text-align: center;
}

:root {
    --primary-blue: #3490dc;
    --primary-blue-light: #6ba3e8;
}

.text-primary {
    color: var(--primary-blue) !important;
}

.bg-primary {
    background-color: var(--primary-blue) !important;
}

.btn-primary {
    background-color: var(--primary-blue);
    border-color: var(--primary-blue);
}

.btn-outline-primary {
    color: var(--primary-blue);
    border-color: var(--primary-blue);
}

.btn-outline-primary:hover {
    background-color: var(--primary-blue);
    border-color: var(--primary-blue);
}

.btn-sm {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
}

.gap-2 {
    gap: 0.5rem !important;
}
</style>

<script>
function blockUser(userId) {
    if (confirm('هل أنت متأكد من حظر هذا المستخدم؟\nAre you sure you want to block this user?')) {
        // هنا يمكن إضافة AJAX request لحظر المستخدم
        alert('تم حظر المستخدم بنجاح\nUser blocked successfully');
        // يمكن إعادة تحميل الصفحة أو تحديث الجدول
        location.reload();
    }
}

function deleteUser(userId) {
    if (confirm('هل أنت متأكد من حذف هذا المستخدم؟ هذا الإجراء لا يمكن التراجع عنه.\nAre you sure you want to delete this user? This action cannot be undone.')) {
        // هنا يمكن إضافة AJAX request لحذف المستخدم
        alert('تم حذف المستخدم بنجاح\nUser deleted successfully');
        // يمكن إعادة تحميل الصفحة أو تحديث الجدول
        location.reload();
    }
}

function openPackagesModal(userId) {
    // يمكن هنا تحميل بيانات الباقات الخاصة بالمستخدم من قاعدة البيانات
    // وتعبئة الحقول بالبيانات الحالية
    const modal = new bootstrap.Modal(document.getElementById('packagesModal'));
    modal.show();
}

function savePackageData(packageType) {
    const ads = document.getElementById(packageType + '_ads').value;
    const price = document.getElementById(packageType + '_price').value;
    const days = document.getElementById(packageType + '_days').value;
    
    if (!ads || !price || !days) {
        alert('يرجى ملء جميع الحقول\nPlease fill all fields');
        return;
    }
    
    if (confirm(`هل تريد حفظ بيانات باقة ${getPackageNameAr(packageType)}؟\nDo you want to save ${packageType} package data?`)) {
        // هنا يمكن إضافة AJAX request لحفظ البيانات في قاعدة البيانات
        alert(`تم حفظ بيانات باقة ${getPackageNameAr(packageType)} بنجاح!\n${packageType} package data saved successfully!`);
    }
}

function saveAllPackages() {
    const packages = ['featured', 'premium', 'premium_star'];
    let allValid = true;
    
    packages.forEach(packageType => {
        const ads = document.getElementById(packageType + '_ads').value;
        const price = document.getElementById(packageType + '_price').value;
        const days = document.getElementById(packageType + '_days').value;
        
        if (!ads || !price || !days) {
            allValid = false;
        }
    });
    
    if (!allValid) {
        alert('يرجى ملء جميع الحقول لجميع الباقات\nPlease fill all fields for all packages');
        return;
    }
    
    if (confirm('هل تريد حفظ جميع بيانات الباقات؟\nDo you want to save all packages data?')) {
        // هنا يمكن إضافة AJAX request لحفظ جميع البيانات
        alert('تم حفظ جميع بيانات الباقات بنجاح!\nAll packages data saved successfully!');
        
        // إغلاق النافذة المنبثقة
        const modal = bootstrap.Modal.getInstance(document.getElementById('packagesModal'));
        modal.hide();
    }
}

function getPackageNameAr(packageType) {
    const names = {
        'featured': 'المميزة',
        'premium': 'البريميوم',
        'premium_star': 'البريميوم ستار'
    };
    return names[packageType] || packageType;
}
</script>
@endsection