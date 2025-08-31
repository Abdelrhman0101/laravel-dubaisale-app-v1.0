@extends('layouts.dashboard')

{{-- Assume CSRF token meta tag is present in layouts.dashboard. If not, add it in the head section: --}}
{{-- @section('head')
    @parent
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="page-title mb-1">
                                <i class="bi bi-check-circle me-2"></i>
                                الموافقة على الإعلانات <small class="text-muted">- Ads Approval</small>
                            </h2>
                            <p class="text-muted mb-0">إدارة الموافقة على الإعلانات قبل نشرها <small>- Manage ads approval before publishing</small></p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-danger fs-6 px-3 py-2" id="pendingAdsCountBadge">
                                <i class="bi bi-clock me-1"></i>
                                في انتظار الموافقة: 0
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- Approval Settings Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        إعدادات الموافقة - Approval Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2">وضع الموافقة اليدوية - Manual Approval Mode</h6>
                            <p class="text-muted mb-0">
                                عند التفعيل: يتطلب موافقة يدوية على كل إعلان قبل النشر<br>
                                عند الإلغاء: يتم قبول الإعلانات تلقائياً<br>
                                <small>When enabled: Requires manual approval for each ad before publishing<br>
                                When disabled: Ads are automatically accepted</small>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="approvalModeSwitch" checked>
                                <label class="form-check-label fw-bold" for="approvalModeSwitch" id="switchLabel">
                                    مفعل - Enabled
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs mb-4" id="adsCategoryTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="carsales-tab" data-bs-toggle="tab" data-bs-target="#carsales-tab-pane" type="button" role="tab" aria-controls="carsales-tab-pane" aria-selected="true" data-category="carsales">
                        <i class="bi bi-car-front-fill me-2"></i> 
                        <span class="tab-text">إعلانات بيع السيارات</span>
                        <small class="d-block text-muted">Car Sales</small>
                        <span class="badge bg-primary ms-2" id="badge-carsales">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="realestate-tab" data-bs-toggle="tab" data-bs-target="#realestate-tab-pane" type="button" role="tab" aria-controls="realestate-tab-pane" aria-selected="false" data-category="realestate">
                        <i class="bi bi-building-fill me-2"></i> 
                        <span class="tab-text">عقارات</span>
                        <small class="d-block text-muted">Real Estate</small>
                        <span class="badge bg-primary ms-2" id="badge-realestate">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="electronics-tab" data-bs-toggle="tab" data-bs-target="#electronics-tab-pane" type="button" role="tab" aria-controls="electronics-tab-pane" aria-selected="false" data-category="electronics">
                        <i class="bi bi-house-door-fill me-2"></i> 
                        <span class="tab-text">إلكترونيات وأجهزة منزلية</span>
                        <small class="d-block text-muted">Electronics & Home</small>
                        <span class="badge bg-primary ms-2" id="badge-electronics">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs-tab-pane" type="button" role="tab" aria-controls="jobs-tab-pane" aria-selected="false" data-category="jobs">
                        <i class="bi bi-briefcase-fill me-2"></i> 
                        <span class="tab-text">وظائف</span>
                        <small class="d-block text-muted">Jobs</small>
                        <span class="badge bg-primary ms-2" id="badge-jobs">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="carrent-tab" data-bs-toggle="tab" data-bs-target="#carrent-tab-pane" type="button" role="tab" aria-controls="carrent-tab-pane" aria-selected="false" data-category="carrent">
                        <i class="bi bi-car-front-fill me-2"></i> 
                        <span class="tab-text">إيجار سيارات</span>
                        <small class="d-block text-muted">Car Rent</small>
                        <span class="badge bg-primary ms-2" id="badge-carrent">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="carservices-tab" data-bs-toggle="tab" data-bs-target="#carservices-tab-pane" type="button" role="tab" aria-controls="carservices-tab-pane" aria-selected="false" data-category="carservices">
                        <i class="bi bi-tools me-2"></i> 
                        <span class="tab-text">خدمات سيارات</span>
                        <small class="d-block text-muted">Car Services</small>
                        <span class="badge bg-primary ms-2" id="badge-carservices">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="restaurants-tab" data-bs-toggle="tab" data-bs-target="#restaurants-tab-pane" type="button" role="tab" aria-controls="restaurants-tab-pane" aria-selected="false" data-category="restaurants">
                        <i class="bi bi-egg-fried me-2"></i> 
                        <span class="tab-text">مطاعم</span>
                        <small class="d-block text-muted">Restaurants</small>
                        <span class="badge bg-primary ms-2" id="badge-restaurants">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="otherservices-tab" data-bs-toggle="tab" data-bs-target="#otherservices-tab-pane" type="button" role="tab" aria-controls="otherservices-tab-pane" aria-selected="false" data-category="otherservices">
                        <i class="bi bi-grid me-2"></i> 
                        <span class="tab-text">خدمات أخرى</span>
                        <small class="d-block text-muted">Other Services</small>
                        <span class="badge bg-primary ms-2" id="badge-otherservices">0</span>
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="adsCategoryTabContent">
                <div class="tab-pane fade show active" id="carsales-tab-pane" role="tabpanel" aria-labelledby="carsales-tab" tabindex="0">
                    <!-- Pending Ads Table for Car Sales -->
                    <div class="card border-0 shadow-sm" id="pendingAdsCard-carsales">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-table me-2"></i>
                                إعلانات بيع السيارات في انتظار الموافقة <small>- Car Sale Pending Ads</small>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pendingAdsTable-carsales">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">صورة الإعلانات - Ads Image</th>
                                            <th>عنوان الإعلان - Ad Title</th>
                                            <th>اسم المعلن - Advertiser Name</th>
                                            <th>تكلفة الإعلان - Ad Cost</th>
                                            <th>القسم - Category</th>
                                            <th>نوع الباقة - Package Type</th>
                                            <th>تاريخ الإرسال - Submission Date</th>
                                            <th class="text-center">الإجراءات - Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adsTableBody-carsales">
                                        <!-- Ad data will be loaded here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="noAdsMessage-carsales" class="text-center p-4 text-muted" style="display: none;">
                                    لا توجد إعلانات بيع سيارات في انتظار الموافقة حالياً.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Real Estate Tab -->
                <div class="tab-pane fade" id="realestate-tab-pane" role="tabpanel" aria-labelledby="realestate-tab" tabindex="0">
                    <div class="card border-0 shadow-sm" id="pendingAdsCard-realestate">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-building-fill me-2"></i>
                                إعلانات العقارات في انتظار الموافقة <small>- Real Estate Pending Ads</small>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pendingAdsTable-realestate">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">صورة الإعلانات -  Ads Image</th>
                                            <th>عنوان الإعلان - Ad Title</th>
                                            <th>اسم المعلن - Advertiser Name</th>
                                            <th>تكلفة الإعلان - Ad Cost</th>
                                            <th>القسم - Category</th>
                                            <th>نوع الباقة - Package Type</th>
                                            <th>تاريخ الإرسال - Submission Date</th>
                                            <th class="text-center">الإجراءات - Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adsTableBody-realestate">
                                        <!-- Ad data will be loaded here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="noAdsMessage-realestate" class="text-center p-4 text-muted" style="display: none;">
                                    لا توجد إعلانات عقارات في انتظار الموافقة حالياً.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Electronics Tab -->
                <div class="tab-pane fade" id="electronics-tab-pane" role="tabpanel" aria-labelledby="electronics-tab" tabindex="0">
                    <div class="card border-0 shadow-sm" id="pendingAdsCard-electronics">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-house-door-fill me-2"></i>
                                إعلانات الإلكترونيات والأجهزة المنزلية في انتظار الموافقة <small>- Electronics & Home Appliances Pending Ads</small>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pendingAdsTable-electronics">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">صورة الإعلانات - Ad Image</th>
                                            <th>عنوان الإعلان - Ad Title</th>
                                            <th>اسم المعلن - Advertiser Name</th>
                                            <th>تكلفة الإعلان - Ad Cost</th>
                                            <th>القسم - Category</th>
                                            <th>نوع الباقة - Package Type</th>
                                            <th>تاريخ الإرسال - Submission Date</th>
                                            <th class="text-center">الإجراءات - Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adsTableBody-electronics">
                                        <!-- Ad data will be loaded here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="noAdsMessage-electronics" class="text-center p-4 text-muted" style="display: none;">
                                    لا توجد إعلانات إلكترونيات وأجهزة منزلية في انتظار الموافقة حالياً.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Jobs Tab -->
                <div class="tab-pane fade" id="jobs-tab-pane" role="tabpanel" aria-labelledby="jobs-tab" tabindex="0">
                    <div class="card border-0 shadow-sm" id="pendingAdsCard-jobs">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-briefcase-fill me-2"></i>
                                إعلانات الوظائف في انتظار الموافقة <small>- Jobs Pending Ads</small>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pendingAdsTable-jobs">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">صورة الإعلانات - Ad Image</th>
                                            <th>عنوان الإعلان - Ad Title</th>
                                            <th>اسم المعلن - Advertiser Name</th>
                                            <th>تكلفة الإعلان - Ad Cost</th>
                                            <th>القسم - Category</th>
                                            <th>نوع الباقة - Package Type</th>
                                            <th>تاريخ الإرسال - Submission Date</th>
                                            <th class="text-center">الإجراءات - Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adsTableBody-jobs">
                                        <!-- Ad data will be loaded here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="noAdsMessage-jobs" class="text-center p-4 text-muted" style="display: none;">
                                    لا توجد إعلانات وظائف في انتظار الموافقة حالياً.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Car Rent Tab -->
                <div class="tab-pane fade" id="carrent-tab-pane" role="tabpanel" aria-labelledby="carrent-tab" tabindex="0">
                    <div class="card border-0 shadow-sm" id="pendingAdsCard-carrent">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-car-side me-2"></i>
                                إعلانات إيجار السيارات في انتظار الموافقة <small>- Car Rent Pending Ads</small>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pendingAdsTable-carrent">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">صورة الإعلانات - Ad Image</th>
                                            <th>عنوان الإعلان - Ad Title</th>
                                            <th>اسم المعلن - Advertiser Name</th>
                                            <th>تكلفة الإعلان - Ad Cost</th>
                                            <th>القسم - Category</th>
                                            <th>نوع الباقة - Package Type</th>
                                            <th>تاريخ الإرسال - Submission Date</th>
                                            <th class="text-center">الإجراءات - Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adsTableBody-carrent">
                                        <!-- Ad data will be loaded here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="noAdsMessage-carrent" class="text-center p-4 text-muted" style="display: none;">
                                    لا توجد إعلانات إيجار سيارات في انتظار الموافقة حالياً.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Car Services Tab -->
                <div class="tab-pane fade" id="carservices-tab-pane" role="tabpanel" aria-labelledby="carservices-tab" tabindex="0">
                    <div class="card border-0 shadow-sm" id="pendingAdsCard-carservices">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-tools me-2"></i>
                                إعلانات خدمات السيارات في انتظار الموافقة <small>- Car Services Pending Ads</small>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pendingAdsTable-carservices">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">صورة الإعلانات - Ad Image</th>
                                            <th>عنوان الإعلان - Ad Title</th>
                                            <th>اسم المعلن - Advertiser Name</th>
                                            <th>تكلفة الإعلان - Ad Cost</th>
                                            <th>القسم - Category</th>
                                            <th>نوع الباقة - Package Type</th>
                                            <th>تاريخ الإرسال - Submission Date</th>
                                            <th class="text-center">الإجراءات - Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adsTableBody-carservices">
                                        <!-- Ad data will be loaded here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="noAdsMessage-carservices" class="text-center p-4 text-muted" style="display: none;">
                                    لا توجد إعلانات خدمات سيارات في انتظار الموافقة حالياً.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Restaurants Tab -->
                <div class="tab-pane fade" id="restaurants-tab-pane" role="tabpanel" aria-labelledby="restaurants-tab" tabindex="0">
                    <div class="card border-0 shadow-sm" id="pendingAdsCard-restaurants">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-egg-fried me-2"></i>
                                إعلانات المطاعم في انتظار الموافقة <small>- Restaurants Pending Ads</small>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pendingAdsTable-restaurants">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">صورة الإعلانات - Ad Image</th>
                                            <th>عنوان الإعلان - Ad Title</th>
                                            <th>اسم المعلن - Advertiser Name</th>
                                            <th>تكلفة الإعلان - Ad Cost</th>
                                            <th>القسم - Category</th>
                                            <th>نوع الباقة - Package Type</th>
                                            <th>تاريخ الإرسال - Submission Date</th>
                                            <th class="text-center">الإجراءات - Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adsTableBody-restaurants">
                                        <!-- Ad data will be loaded here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="noAdsMessage-restaurants" class="text-center p-4 text-muted" style="display: none;">
                                    لا توجد إعلانات مطاعم في انتظار الموافقة حالياً.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Other Services Tab -->
                <div class="tab-pane fade" id="otherservices-tab-pane" role="tabpanel" aria-labelledby="otherservices-tab" tabindex="0">
                    <div class="card border-0 shadow-sm" id="pendingAdsCard-otherservices">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-gear-fill me-2"></i>
                                إعلانات الخدمات الأخرى في انتظار الموافقة <small>- Other Services Pending Ads</small>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pendingAdsTable-otherservices">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">صورة الإعلانات - Ad Image</th>
                                            <th>عنوان الإعلان - Ad Title</th>
                                            <th>اسم المعلن - Advertiser Name</th>
                                            <th>تكلفة الإعلان - Ad Cost</th>
                                            <th>القسم - Category</th>
                                            <th>نوع الباقة - Package Type</th>
                                            <th>تاريخ الإرسال - Submission Date</th>
                                            <th class="text-center">الإجراءات - Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adsTableBody-otherservices">
                                        <!-- Ad data will be loaded here by JavaScript -->
                                    </tbody>
                                </table>
                                <div id="noAdsMessage-otherservices" class="text-center p-4 text-muted" style="display: none;">
                                    لا توجد إعلانات خدمات أخرى في انتظار الموافقة حالياً.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Auto Approval Message (General) -->
                <div class="card border-0 shadow-sm" id="autoApprovalCard" style="display: none;">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-success mb-3">الموافقة التلقائية مفعلة - Auto Approval Enabled</h4>
                        <p class="text-muted mb-0">
                            جميع الإعلانات يتم قبولها تلقائياً بدون الحاجة للموافقة اليدوية<br>
                            <small>All ads are automatically accepted without manual approval</small>
                        </p>
                    </div>
                </div>
            </div> {{-- End tab-content --}}
        </div>
    </div>
</div>

<!-- Ad Details Modal -->
<div class="modal fade" id="adDetailsModal" tabindex="-1" aria-labelledby="adDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="adDetailsModalLabel">تفاصيل الإعلان - Ad Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="adDetailsModalBody">
                <!-- Ad details will be loaded here by JavaScript -->
                <p>جارٍ تحميل تفاصيل الإعلان...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق - Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.ad-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.form-check-input {
    width: 3rem;
    height: 1.5rem;
}

.card {
    transition: all 0.3s ease;
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.badge {
    font-size: 0.75rem;
}

.page-title {
    color: #2c3e50;
    font-weight: 600;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.bg-gradient-danger { /* Kept for potential future use or consistency */
    background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
}

#pendingAdsCard-carsales, #autoApprovalCard {
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.fade-in {
    opacity: 1;
    transform: translateY(0);
}

.fade-out {
    opacity: 0;
    transform: translateY(-20px);
}

/* Enhanced Tab Styling */
.nav-tabs {
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 1.5rem;
    align-items: center;
    justify-content: center;
}

.nav-tabs .nav-link {
    border-radius: 12px 12px 0 0;
    margin-right: 8px;
    padding: 15px 20px;
    border: 2px solid transparent;
    background: #f8f9fa;
    color: #6c757d;
    transition: all 0.3s ease;
    position: relative;
    min-height: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.nav-tabs .nav-link:hover {
    background: #e9ecef;
    color: #495057;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.nav-tabs .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3);
}

.nav-tabs .nav-link.active .badge {
    background-color: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
}

.nav-tabs .nav-link .tab-text {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 2px;
}

.nav-tabs .nav-link small {
    font-size: 0.75rem;
    opacity: 0.8;
}

.nav-tabs .nav-link .badge {
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 0.7rem;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-tabs .nav-link i {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

/* Style for disabled tabs */
.nav-tabs .nav-link.disabled {
    color: #6c757d;
    pointer-events: none; /* Disables click */
    background-color: #f8f9fa; /* Lighter background */
    border-color: #e9ecef #e9ecef #e9ecef;
    cursor: not-allowed; /* Indicate it's not clickable */
}

/* Style for modal button in dark mode to avoid white text on white */
.modal-header .btn-close.btn-close-white {
    filter: brightness(0) invert(1); /* Makes the button icon white for dark backgrounds */
}

/* Responsive Design for Tabs */
@media (max-width: 768px) {
    .nav-tabs .nav-link {
        padding: 10px 8px;
        min-height: 60px;
        margin-right: 4px;
    }
    .nav-tabs .nav-link .tab-text {
        font-size: 0.8rem;
    }
    .nav-tabs .nav-link small {
        font-size: 0.7rem;
    }
    .nav-tabs .nav-link i {
        font-size: 1rem;
    }
}

</style>

<script>

        // =========================================================
    // ====      حارس الحماية الخاص بالواجهة الأمامية      ====
    // =========================================================
    (function() {
        const token = localStorage.getItem('token');
        const userJson = localStorage.getItem('user');
        
        let user = null;
        try {
            if (userJson) {
                user = JSON.parse(userJson);
            }
        } catch (e) {
            console.error("Error parsing user data from localStorage", e);
        }

        // شروط عدم السماح بالدخول:
        // 1. لا يوجد توكن
        // 2. لا توجد بيانات مستخدم
        // 3. المستخدم ليس له دور 'admin'
        if (!token || !user || user.role !== 'admin') {
            // امسح أي بيانات قديمة وغير صالحة
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            
            // قم بتوجيه المستخدم فورًا إلى صفحة تسجيل الدخول
            window.location.href = '{{ route("login") }}';
        }
    })();
    // =========================================================

    
    // =========================================================================
    // SECTION 1: CONFIGURATION & INITIAL DATA (FROM LARAVEL CONTROLLER)
    // =========================================================================

    // قراءة البيانات الديناميكية التي تم تمريرها من الـ Controller
    const BASE_URL = '{{ config("app.url") }}';
    const ADMIN_TOKEN = '{{ $adminToken }}';
    let isManualApprovalActive = {{ $isManualApprovalActive ? 'true' : 'false' }};
    
    // تحويل مصفوفة PHP الخاصة بالإعلانات المعلقة إلى كائن JavaScript
    // هذا يسرع تحميل الصفحة لأن البيانات الأولية تكون جاهزة فورًا
    let pendingAdsData = @json($pendingAds); 

    // تعريف كل نقاط النهاية (API Endpoints) التي سنحتاجها في مكان واحد
    const API_ENDPOINTS = {
        settings: `${BASE_URL}/api/admin/system-settings/manual_approval_mode`,
        pendingAds: `${BASE_URL}/api/admin/ads/pending`,
        approveAd: `${BASE_URL}/api/admin/ads/{id}/approve`,
        rejectAd: `${BASE_URL}/api/admin/ads/{id}/reject`,
        adDetails: `${BASE_URL}/api/car-sales-ads/{id}` // لعرض تفاصيل الإعلان الكاملة
    };


    // =========================================================================
    // SECTION 2: EVENT LISTENERS & INITIALIZATION
    // =========================================================================

    document.addEventListener('DOMContentLoaded', function() {
        const approvalSwitch = document.getElementById('approvalModeSwitch');
        
        // --- 1. التهيئة الأولية للصفحة عند تحميلها ---
        approvalSwitch.checked = isManualApprovalActive;
        updateUIBasedOnApprovalMode();
        renderAllTablesInitially();
        updateAllBadges();

        // --- 2. ربط الأحداث (Event Listeners) ---
        // تغيير حالة مفتاح الموافقة اليدوية
        approvalSwitch.addEventListener('change', handleApprovalSwitchToggle);

        // استخدام Event Delegation لمعالجة كل أزرار الإجراءات في الجداول
        document.getElementById('adsCategoryTabContent').addEventListener('click', function(event) {
            const button = event.target.closest('button[data-ad-id]');
            if (!button) return; // تجاهل أي ضغطة ليست على زر يحمل data-ad-id

            const adId = button.dataset.adId;
            const category = button.closest('.tab-pane').id.replace('-tab-pane', '');
            
            if (button.title.includes('Approve')) {
                handleAdAction(adId, category, 'approve');
            } else if (button.title.includes('Reject')) {
                handleAdAction(adId, category, 'reject');
            } else if (button.title.includes('View')) {
                showAdDetails(adId, category);
            }
        });
    });


    // =========================================================================
    // SECTION 3: CORE LOGIC & API HANDLERS
    // =========================================================================

    /**
     * دالة مركزية لتحديث واجهة المستخدم بناءً على وضع الموافقة.
     */
    function updateUIBasedOnApprovalMode() {
        const switchLabel = document.getElementById('switchLabel');
        const autoApprovalCard = document.getElementById('autoApprovalCard');
        const tabsAndContent = document.getElementById('adsCategoryTabContent');

        if (isManualApprovalActive) {
            switchLabel.textContent = 'مفعل - Enabled';
            switchLabel.className = 'form-check-label fw-bold text-success';
            autoApprovalCard.style.display = 'none';
            tabsAndContent.style.display = 'block';
        } else {
            switchLabel.textContent = 'معطل - Disabled';
            switchLabel.className = 'form-check-label fw-bold text-danger';
            autoApprovalCard.style.display = 'block';
            tabsAndContent.style.display = 'none';
        }
    }
    
    /**
     * دالة مركزية لمعالجة تغيير حالة مفتاح الموافقة.
     */
    async function handleApprovalSwitchToggle() {
        const isChecked = this.checked;
        const newValue = isChecked ? 'true' : 'false';

        try {
            const response = await fetch(API_ENDPOINTS.settings, {
                method: 'PUT',
                headers: getAuthHeaders(),
                body: JSON.stringify({ value: newValue })
            });
            const result = await response.json();

            if (!response.ok) throw new Error(result.message || 'Failed to update setting');
            
            isManualApprovalActive = isChecked;
            showAlert('تم تحديث إعدادات الموافقة بنجاح.', 'success');
            updateUIBasedOnApprovalMode();

        } catch (error) {
            console.error('Error updating approval mode:', error);
            showAlert('حدث خطأ أثناء تحديث الإعدادات.', 'danger');
            this.checked = !isChecked; // إعادة السويتش لحالته السابقة عند الفشل
        }
    }
    
    /**
     * دالة مركزية لمعالجة الموافقة أو الرفض.
     */
    async function handleAdAction(adId, category, actionType) {
        const confirmMessages = {
            approve: 'هل أنت متأكد من الموافقة على هذا الإعلان؟',
            reject: 'هل أنت متأكد من رفض هذا الإعلان؟'
        };
        const successMessages = {
            approve: 'تمت الموافقة على الإعلان بنجاح.',
            reject: 'تم رفض الإعلان بنجاح.'
        };
        
        if (confirm(confirmMessages[actionType])) {
            try {
                const endpoint = API_ENDPOINTS[`${actionType}Ad`].replace('{id}', adId);
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: getAuthHeaders()
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'An unknown error occurred.');
                }

                showAlert(successMessages[actionType], actionType === 'approve' ? 'success' : 'warning');
                removeAdFromLocalData(adId, category);
                renderAdsTable(category, pendingAdsData[category]);
                updateAllBadges();
            } catch (error) {
                console.error(`Error ${actionType} ad:`, error);
                showAlert(`حدث خطأ: ${error.message}`, 'danger');
            }
        }
    }


    // =========================================================================
    // SECTION 4: RENDERING & UI HELPERS
    // =========================================================================

    /**
     * عرض الجداول بالبيانات الأولية المحملة من الخادم.
     */
    function renderAllTablesInitially() {
        for (const category in pendingAdsData) {
            if (pendingAdsData.hasOwnProperty(category)) {
                renderAdsTable(category, pendingAdsData[category]);
            }
        }
    }

    /**
     * تحديث كل شارات الأرقام في التابات وفي الهيدر.
     */
    function updateAllBadges() {
         let totalCount = 0;
         for (const category in pendingAdsData) {
             const count = pendingAdsData[category]?.length || 0;
             updateCategoryBadge(category, count);
             totalCount += count;
         }
         updatePendingAdsCountBadge(totalCount);
    }

    /**
     * عرض الإعلانات في الجدول الخاص بكل قسم.
     */
    function renderAdsTable(category, ads) {
        const tableBody = document.getElementById(`adsTableBody-${category}`);
        const noAdsMessage = document.getElementById(`noAdsMessage-${category}`);
        if (!tableBody || !noAdsMessage) return;

        tableBody.innerHTML = ''; 

        if (!ads || ads.length === 0) {
            noAdsMessage.style.display = 'block';
            return;
        }

        noAdsMessage.style.display = 'none';

        ads.forEach(ad => {
            const row = document.createElement('tr');
            row.id = `ad-row-${ad.id}`; // Add a unique ID for easy removal
            const adImage = ad.main_image ? `${BASE_URL}/storage/${ad.main_image}` : `https://via.placeholder.com/60x60/eee/999?text=N/A`;
            const submissionDate = new Date(ad.created_at).toLocaleDateString('ar-EG');
            const planType = ad.plan_type || 'Free';

            row.innerHTML = `
                <td class="text-center"><img src="${adImage}" alt="Ad Image" class="rounded ad-image"></td>
                <td><div class="fw-bold">${ad.title}</div><small class="text-muted">ID: ${ad.id}</small></td>
                <td>${ad.advertiser_name}</td>
                <td>${parseFloat(ad.price).toFixed(2)} AED</td>
                <td>${ad.add_category}</td>
                <td><span class="badge bg-info">${planType}</span></td>
                <td>${submissionDate}</td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-info" title="View Details" data-ad-id="${ad.id}"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-success" title="Approve Ad" data-ad-id="${ad.id}"><i class="bi bi-check-lg"></i></button>
                        <button class="btn btn-sm btn-danger" title="Reject Ad" data-ad-id="${ad.id}"><i class="bi bi-x-lg"></i></button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    /**
     * عرض تفاصيل الإعلان الكاملة في نافذة منبثقة (Modal).
     */
    async function showAdDetails(adId, category) {
        const modalBody = document.getElementById('adDetailsModalBody');
        modalBody.innerHTML = `<div class="text-center p-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading...</p></div>`;
        const adDetailsModal = new bootstrap.Modal(document.getElementById('adDetailsModal'));
        adDetailsModal.show();
        
        try {
            const response = await fetch(API_ENDPOINTS.adDetails.replace('{id}', adId), { headers: getAuthHeaders() });
            if (!response.ok) throw new Error('Ad not found or error fetching details.');
            
            const ad = await response.json();
            
            // Build a detailed HTML string from the 'ad' object
            // This can be customized to show as many details as you want
            modalBody.innerHTML = `
                <h5>${ad.title}</h5>
                <p>${ad.description}</p>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Price:</strong> ${ad.price} AED</li>
                    <li class="list-group-item"><strong>Make:</strong> ${ad.make}</li>
                    <li class="list-group-item"><strong>Model:</strong> ${ad.model}</li>
                    <li class="list-group-item"><strong>Year:</strong> ${ad.year}</li>
                    <li class="list-group-item"><strong>KM:</strong> ${ad.km}</li>
                </ul>
            `;

        } catch (error) {
            console.error("Error fetching ad details:", error);
            modalBody.innerHTML = `<p class="text-danger">Failed to load ad details. ${error.message}</p>`;
        }
    }


    // =========================================================================
    // SECTION 5: UTILITY & HELPER FUNCTIONS
    // =========================================================================
    
    /**
     * دالة مساعدة لإنشاء Headers المصادقة.
     * النسخة المصححة التي تقرأ التوكن من Local Storage.
     */
    function getAuthHeaders() {
        // 1. اقرأ التوكن الحقيقي من Local Storage الذي وضعه نظام تسجيل الدخول.
        const token = localStorage.getItem('token');

        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // 2. أضف الـ Authorization header فقط إذا كان التوكن موجودًا.
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        return headers;
    }

    /**
     * إزالة الإعلان من البيانات المحلية بعد الموافقة أو الرفض.
     */
    function removeAdFromLocalData(adId, category) {
        if (pendingAdsData[category]) {
            pendingAdsData[category] = pendingAdsData[category].filter(ad => ad.id != adId);
        }
    }
    
    /**
     * تحديث شارة الأرقام الخاصة بقسم معين.
     */
    function updateCategoryBadge(category, count) {
        const badge = document.getElementById(`badge-${category}`);
        if (badge) {
            badge.textContent = count;
        }
    }

    /**
     * تحديث شارة الأرقام العامة في أعلى الصفحة.
     */
    function updatePendingAdsCountBadge(totalCount) {
        const badge = document.getElementById('pendingAdsCountBadge');
        if (badge) {
            badge.innerHTML = `<i class="bi bi-clock me-1"></i> في انتظار الموافقة: ${totalCount}`;
        }
    }
    
    /**
     * عرض رسالة تنبيه ديناميكية للمستخدم.
     */
    function showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show m-3`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        alertContainer.prepend(alertDiv);
        setTimeout(() => bootstrap.Alert.getOrCreateInstance(alertDiv).close(), 5000);
    }

</script>
@endsection