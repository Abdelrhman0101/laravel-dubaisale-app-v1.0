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
    // Make sure 'APP_URL' is correctly set in your Laravel .env file
    // Example: APP_URL=http://localhost:8000 or APP_URL=https://your-domain.com
    const BASE_URL = 'http://localhost:8000';
    const API_PENDING_ADS = `${BASE_URL}/api/admin/ads/pending`;
    const API_APPROVE_AD = `${BASE_URL}/api/admin/ads/{id}/approve`;
    const API_REJECT_AD = `${BASE_URL}/api/admin/ads/{id}/reject`;

    // Function to get CSRF token from meta tag
    function getCsrfToken() {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        return tokenMeta ? tokenMeta.getAttribute('content') : '';
    }

    // Function to get Bearer token from localStorage
    function getBearerToken() {
        // For local testing, provide a default token if none exists
        let token = localStorage.getItem('token');
        if (!token) {
            // Set a dummy token for local testing
            token = 'dummy-token-for-local-testing';
            localStorage.setItem('token', token);
        }
        return token;
        //  return localStorage.getItem('token') || '';
    }

    // Function to create headers with Bearer token
    function getAuthHeaders() {
        const token = getBearerToken();
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
        
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }
        
        const csrfToken = getCsrfToken();
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken;
        }
        
        return headers;
    }

    // Storage for fetched ads data, organized by category
    // For now, only 'carsales' will have actual data
    let pendingAdsData = {
        'carsales': []
    };

    // Current active category
    let currentCategory = 'carsales';
    
    document.addEventListener('DOMContentLoaded', function() {
        const approvalSwitch = document.getElementById('approvalModeSwitch');
        const switchLabel = document.getElementById('switchLabel');
        const pendingAdsCardCarSales = document.getElementById('pendingAdsCard-carsales');
        const autoApprovalCard = document.getElementById('autoApprovalCard');
        const noAdsMessageCarSales = document.getElementById('noAdsMessage-carsales');
        
        // Initialize tabs
        initializeTabs();

        // Initial check for switch state (important if user refreshes page and state persists)
        if (approvalSwitch.checked) {
            fetchPendingAds('carsales'); // Fetch data only for car sales initially
            switchLabel.textContent = 'مفعل - Enabled';
            switchLabel.className = 'form-check-label fw-bold text-success';
            pendingAdsCardCarSales.style.display = 'block';
            autoApprovalCard.style.display = 'none';
        } else {
            switchLabel.textContent = 'معطل - Disabled';
            switchLabel.className = 'form-check-label fw-bold text-danger';
            pendingAdsCardCarSales.style.display = 'none';
            autoApprovalCard.style.display = 'block';
        }

        // Handle switch toggle
        approvalSwitch.addEventListener('change', function() {
            if (this.checked) {
                // Manual approval mode
                switchLabel.textContent = 'مفعل - Enabled';
                switchLabel.className = 'form-check-label fw-bold text-success';

                autoApprovalCard.classList.remove('fade-in');
                autoApprovalCard.classList.add('fade-out');
                setTimeout(() => {
                    autoApprovalCard.style.display = 'none';
                    pendingAdsCardCarSales.style.display = 'block';
                    pendingAdsCardCarSales.classList.add('fade-in');
                    pendingAdsCardCarSales.classList.remove('fade-out');
                    fetchPendingAds('carsales'); // Fetch data when manual mode is re-enabled
                }, 300); // Allow fade-out to complete first

            } else {
                // Auto approval mode
                switchLabel.textContent = 'معطل - Disabled';
                switchLabel.className = 'form-check-label fw-bold text-danger';

                pendingAdsCardCarSales.classList.add('fade-out');
                pendingAdsCardCarSales.classList.remove('fade-in');
                setTimeout(() => {
                    pendingAdsCardCarSales.style.display = 'none';
                    autoApprovalCard.style.display = 'block';
                    autoApprovalCard.classList.add('fade-in');
                    autoApprovalCard.classList.remove('fade-out');
                    // Optionally clear the table when auto-approval is enabled
                    document.getElementById('adsTableBody-carsales').innerHTML = '';
                    pendingAdsData['carsales'] = [];
                    updatePendingAdsCount();
                }, 300);
            }
        });

        // Initialize tab functionality
         function initializeTabs() {
             const tabButtons = document.querySelectorAll('#adsCategoryTabs .nav-link');
             
             // Load counts for all categories on initialization
             loadAllCategoriesCounts();
             
             tabButtons.forEach(button => {
                 button.addEventListener('click', function(e) {
                     e.preventDefault();
                     
                     // Remove active class from all tabs
                     tabButtons.forEach(btn => {
                         btn.classList.remove('active');
                         btn.setAttribute('aria-selected', 'false');
                     });
                     
                     // Hide all tab panes
                     document.querySelectorAll('.tab-pane').forEach(pane => {
                         pane.classList.remove('show', 'active');
                     });
                     
                     // Add active class to clicked tab
                     this.classList.add('active');
                     this.setAttribute('aria-selected', 'true');
                     
                     // Show corresponding tab pane
                     const targetPaneId = this.getAttribute('data-bs-target');
                     const targetPane = document.querySelector(targetPaneId);
                     if (targetPane) {
                         targetPane.classList.add('show', 'active');
                     }
                     
                     // Get category from data attribute
                     const category = this.getAttribute('data-category');
                     if (category) {
                         currentCategory = category;
                         
                         // Fetch data for the selected category when approval mode is on
                         if (approvalSwitch.checked) {
                             fetchPendingAds(category);
                         }
                         
                         // Update visibility of cards based on category and approval mode
                         updateCardVisibility(category);
                     }
                 });
             });
         }
        
        // Function to update card visibility based on category and approval mode
        function updateCardVisibility(category) {
            // Hide all category cards first
            const allCategoryCards = [
                'pendingAdsCard-carsales',
                'pendingAdsCard-realestate', 
                'pendingAdsCard-electronics',
                'pendingAdsCard-jobs',
                'pendingAdsCard-carrent',
                'pendingAdsCard-carservices',
                'pendingAdsCard-restaurants',
                'pendingAdsCard-otherservices'
            ];
            
            allCategoryCards.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.display = 'none';
                }
            });
            
            // Hide auto approval card
            autoApprovalCard.style.display = 'none';
            
            // Show appropriate card based on approval mode and category
            if (approvalSwitch.checked) {
                // Manual approval mode - show the category card
                const categoryCard = document.getElementById(`pendingAdsCard-${category}`);
                if (categoryCard) {
                    categoryCard.style.display = 'block';
                }
            } else {
                // Auto approval mode - show auto approval message
                autoApprovalCard.style.display = 'block';
            }
        }
    });

    // Helper function to update pending ads count badge
    function updatePendingAdsCount() {
        // Calculate total count from all categories
        let totalCount = 0;
        const categories = ['carsales', 'realestate', 'electronics', 'jobs', 'carrent', 'carservices', 'restaurants', 'otherservices'];
        
        categories.forEach(category => {
            if (pendingAdsData[category]) {
                totalCount += pendingAdsData[category].length;
            }
        });
        
        const pendingAdsCountBadge = document.getElementById('pendingAdsCountBadge');
        pendingAdsCountBadge.innerHTML = `<i class="bi bi-clock me-1"></i> في انتظار الموافقة: ${totalCount}`;

    }

    // Function to fetch pending ads for a given category
    async function fetchPendingAds(category) {
        if (!document.getElementById('approvalModeSwitch').checked) {
            // Do not fetch if auto-approval is enabled
            pendingAdsData[category] = [];
            renderAdsTable(category, []);
            updatePendingAdsCount();
            updateCategoryBadge(category, 0);
            return;
        }

        const tableBody = document.getElementById(`adsTableBody-${category}`);
        // Show loading spinner
        tableBody.innerHTML = `<tr><td colspan="8" class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">جارٍ تحميل الإعلانات...</p></td></tr>`;

        try {
            const response = await fetch(`${API_PENDING_ADS}?category=${category}`, {
                method: 'GET',
                headers: getAuthHeaders()
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            pendingAdsData[category] = data.data; // Store full ad objects
            renderAdsTable(category, pendingAdsData[category]);
            updatePendingAdsCount();
            updateCategoryBadge(category, pendingAdsData[category].length);
        } catch (error) {
            console.error('Error fetching pending ads:', error);
            showAlert('حدث خطأ أثناء جلب الإعلانات المعلقة. الرجاء مراجعة سجلات الخادم.', 'danger');
            // Display error message in table
            tableBody.innerHTML = `<tr><td colspan="8" class="text-center text-danger p-4"><i class="bi bi-x-circle-fill me-2"></i> حدث خطأ أثناء تحميل البيانات.</td></tr>`;
            pendingAdsData[category] = []; // Clear data on error
            updatePendingAdsCount();
            updateCategoryBadge(category, 0);
        }
    }

    // Function to update category badge count
    function updateCategoryBadge(category, count) {
        const badge = document.getElementById(`badge-${category}`);
        if (badge) {
            badge.textContent = count;
            badge.className = count > 0 ? 'badge bg-danger ms-2' : 'badge bg-secondary ms-2';
        }
    }

    // Function to load all categories count on page load
    async function loadAllCategoriesCounts() {
        const categories = ['carsales', 'realestate', 'electronics', 'jobs', 'carrent', 'carservices', 'restaurants', 'otherservices'];
        
        for (const category of categories) {
            try {
                const response = await fetch(`${API_PENDING_ADS}?category=${category}`, {
                    method: 'GET',
                    headers: getAuthHeaders()
                });
                
                if (response.ok) {
                    const data = await response.json();
                    const count = (data.success && data.data) ? data.data.length : 0;
                    updateCategoryBadge(category, count);
                } else {
                    updateCategoryBadge(category, 0);
                }
            } catch (error) {
                console.error(`Error fetching count for ${category}:`, error);
                updateCategoryBadge(category, 0);
            }
        }
    }

    // Function to render the ads table with data
    function renderAdsTable(category, ads) {
        const tableBody = document.getElementById(`adsTableBody-${category}`);
        tableBody.innerHTML = ''; // Clear existing rows

        if (ads.length === 0) {
            document.getElementById(`noAdsMessage-${category}`).style.display = 'block';
            return;
        }

        document.getElementById(`noAdsMessage-${category}`).style.display = 'none';

        ads.forEach(ad => {
            const row = document.createElement('tr');
            row.setAttribute('data-ad-id', ad.id); // Add data-ad-id to row for easy targeting

            const adImage = ad.main_image ? `${BASE_URL}/storage/${ad.main_image}` : 'https://via.placeholder.com/60x60/ffc107/000000?text=AD';
            const submissionDateAr = new Date(ad.created_at).toLocaleDateString('ar-EG', { year: 'numeric', month: '2-digit', day: '2-digit' });
            const submissionDateEn = new Date(ad.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            const planTypeBadge = getPlanTypeBadge(ad.plan_type);

            row.innerHTML = `
                <td class="text-center">
                    <img src="${adImage}" alt="صورة الإعلان" class="rounded ad-image">
                </td>
                <td>
                    <div class="fw-bold text-dark">${ad.title}</div>
                    <small class="text-muted">${ad.title}</small>
                </td>
                <td>
                    <div class="fw-semibold">${ad.advertiser_name}</div>
                    <small class="text-muted">${ad.advertiser_name}</small>
                </td>
                <td>
                    <span class="badge bg-success">${parseFloat(ad.price).toFixed(2)} ريال</span>
                    <small class="d-block text-muted">${parseFloat(ad.price).toFixed(2)} SAR</small>
                </td>
                <td>
                    <span class="badge bg-info">${ad.add_category}</span>
                    <small class="d-block text-muted">${ad.add_category}</small>
                </td>
                <td>
                    ${planTypeBadge.html}
                    <small class="d-block text-muted">${planTypeBadge.textEn}</small>
                </td>
                <td>
                    <div>${submissionDateAr}</div>
                    <small class="text-muted">${submissionDateEn}</small>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-info" title="عرض - View" data-bs-toggle="modal" data-bs-target="#adDetailsModal" data-ad-id="${ad.id}" onclick="showAdDetails(this)">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-success" title="موافقة - Approve" data-ad-id="${ad.id}" onclick="approveAd(this)">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="رفض - Reject" data-ad-id="${ad.id}" onclick="rejectAd(this)">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Helper to get plan type badge styling
    function getPlanTypeBadge(planType) {
        let badgeClass = 'bg-secondary';
        let textAr = 'عادي';
        let textEn = 'Standard';

        if (planType === 'Premium') {
            badgeClass = 'bg-primary';
            textAr = 'بريميوم';
            textEn = 'Premium';
        } else if (planType === 'Featured') {
            badgeClass = 'bg-danger';
            textAr = 'مميز';
            textEn = 'Featured';
        }
        return {
            html: `<span class="badge ${badgeClass}">${textAr}</span>`,
            textEn: textEn
        };
    }

    // Function to display ad details in a modal
    async function showAdDetails(buttonElement) {
        const adId = buttonElement.dataset.adId;
        const ad = pendingAdsData['carsales'].find(a => a.id == adId);

        const modalBody = document.getElementById('adDetailsModalBody');
        if (!ad) {
            modalBody.innerHTML = `<p class="text-danger">لم يتم العثور على تفاصيل الإعلان.</p>`;
            return;
        }

        let thumbnailsHtml = '';
        if (ad.thumbnail_images && ad.thumbnail_images.length > 0) {
            thumbnailsHtml = `<h6 class="mt-4">صور مصغرة:</h6><div class="d-flex flex-wrap gap-2 mb-3">`;
            ad.thumbnail_images.forEach(thumb => {
                thumbnailsHtml += `<img src="${BASE_URL}/storage/${thumb}" alt="Thumbnail" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">`;
            });
            thumbnailsHtml += `</div>`;
        }

        modalBody.innerHTML = `
            <div class="d-flex align-items-center mb-3">
                <img src="${ad.main_image ? `${BASE_URL}/storage/${ad.main_image}` : 'https://via.placeholder.com/100x100/ffc107/000000?text=AD'}" alt="صورة الإعلان الرئيسية" class="rounded me-3" style="width: 100px; height: 100px; object-fit: cover;">
                <div>
                    <h5 class="mb-1">${ad.title}</h5>
                    <p class="text-muted mb-0"><strong>المعلن:</strong> ${ad.advertiser_name || 'N/A'} | <strong>القسم:</strong> ${ad.add_category || 'N/A'}</p>
                </div>
            </div>
            <hr>
            <h6>تفاصيل الإعلان:</h6>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>الوصف:</strong> ${ad.description || 'لا يوجد'}</li>
                <li class="list-group-item"><strong>السعر:</strong> ${parseFloat(ad.price).toFixed(2)} ريال</li>
                <li class="list-group-item"><strong>نوع الباقة:</strong> ${getPlanTypeBadge(ad.plan_type).textAr}</li>
                <li class="list-group-item"><strong>تاريخ الإرسال:</strong> ${new Date(ad.created_at).toLocaleString('ar-EG', { dateStyle: 'medium', timeStyle: 'short' })}</li>
                <li class="list-group-item"><strong>المشاهدات:</strong> ${ad.views}</li>
            </ul>
            <h6>تفاصيل السيارة:</h6>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>الشركة المصنعة:</strong> ${ad.make || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>الموديل:</strong> ${ad.model || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>التقليم/النوع:</strong> ${ad.trim || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>السنة:</strong> ${ad.year || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>عدد الكيلومترات:</strong> ${ad.km ? `${ad.km} كم` : 'غير متوفر'}</li>
                <li class="list-group-item"><strong>نوع السيارة:</strong> ${ad.car_type || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>ناقل الحركة:</strong> ${ad.trans_type || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>نوع الوقود:</strong> ${ad.fuel_type || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>اللون الخارجي:</strong> ${ad.color || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>اللون الداخلي:</strong> ${ad.interior_color || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>الضمان:</strong> ${ad.warranty ? 'نعم' : 'لا'}</li>
                <li class="list-group-item"><strong>سعة المحرك:</strong> ${ad.engine_capacity ? `${ad.engine_capacity} سم مكعب` : 'غير متوفر'}</li>
                <li class="list-group-item"><strong>عدد الأسطوانات:</strong> ${ad.cylinders || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>قوة الأحصنة:</strong> ${ad.horsepower ? `${ad.horsepower} حصان` : 'غير متوفر'}</li>
                <li class="list-group-item"><strong>عدد الأبواب:</strong> ${ad.doors_no || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>عدد المقاعد:</strong> ${ad.seats_no || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>جانب المقود:</strong> ${ad.steering_side || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>المواصفات:</strong> ${ad.specs || 'غير متوفر'}</li>
            </ul>
            <h6>معلومات الاتصال والموقع:</h6>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>رقم الهاتف:</strong> ${ad.phone_number || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>واتساب:</strong> ${ad.whatsapp || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>الامارة:</strong> ${ad.emirate || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>المنطقة:</strong> ${ad.area || 'غير متوفر'}</li>
                <li class="list-group-item"><strong>نوع المعلن:</strong> ${ad.advertiser_type || 'غير متوفر'}</li>
            </ul>
            ${thumbnailsHtml}
        `;
    }

    // Generic function to send approve/reject action to API
    async function sendAdAction(adId, actionType, confirmMessage, successMessage, errorMessage) {
        if (confirm(confirmMessage)) {
            try {
                const endpoint = actionType === 'approve' ? API_APPROVE_AD : API_REJECT_AD;
                const response = await fetch(endpoint.replace('{id}', adId), {
                    method: 'POST',
                    headers: getAuthHeaders(),
                    body: JSON.stringify({}) // Empty body for a simple POST request
                });

                const result = await response.json();
                if (!response.ok) {
                    throw new Error(result.message || `HTTP error! status: ${response.status}`);
                }

                showAlert(successMessage, actionType === 'approve' ? 'success' : 'warning');
                removeAdLocally(adId, 'carsales'); // Update local data for 'carsales'
                updatePendingAdsCount();

            } catch (error) {
                console.error(`Error ${actionType} ad:`, error);
                showAlert(`${errorMessage}: ${error.message || ''}`, 'danger');
            }
        }
    }

    // Wrapper function for approving an ad
    function approveAd(buttonElement) {
        const adId = buttonElement.dataset.adId;
        sendAdAction(
            adId,
            'approve',
            'هل أنت متأكد من الموافقة على هذا الإعلان؟',
            'تمت الموافقة على الإعلان بنجاح.',
            'حدث خطأ أثناء الموافقة على الإعلان'
        );
    }

    // Wrapper function for rejecting an ad
    function rejectAd(buttonElement) {
        const adId = buttonElement.dataset.adId;
        sendAdAction(
            adId,
            'reject',
            'هل أنت متأكد من رفض هذا الإعلان؟',
            'تم رفض الإعلان بنجاح.',
            'حدث خطأ أثناء رفض الإعلان'
        );
    }

    // Function to remove an ad from local data storage
    function removeAdLocally(adId, category) {
        pendingAdsData[category] = pendingAdsData[category].filter(ad => ad.id != adId);
        removeAdRow(adId); // Remove from UI
    }

    // Function to remove ad row from the UI with animation
    function removeAdRow(adId) {
        const row = document.querySelector(`tr[data-ad-id="${adId}"]`);
        if (row) {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '0';
            row.style.transform = 'translateX(-100%)'; // Slide out animation
            setTimeout(() => {
                row.remove();
            }, 300); // Remove after animation
        }
    }

    // Function to display alert messages
    function showAlert(message, type) {
        const alertContainer = document.getElementById('alertContainer');
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        alertContainer.appendChild(alertDiv);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            // Check if alert still exists before attempting to remove
            if (alertDiv.parentNode) {
                const bootstrapAlert = bootstrap.Alert.getInstance(alertDiv);
                if (bootstrapAlert) {
                    bootstrapAlert.close();
                } else {
                    alertDiv.remove(); // Fallback if Bootstrap Alert instance is not found
                }
            }
        }, 5000);
    }
</script>
@endsection