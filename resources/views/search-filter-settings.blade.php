@extends('layouts.dashboard')

@section('title', 'تغيير بيانات البحث والفلتر - Search & Filter Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary mb-1">تغيير بيانات البحث والفلتر</h2>
                    <p class="text-muted mb-0">Search & Filter Settings Management</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="#">إدارة التطبيق</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تغيير بيانات البحث والفلتر</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="tabs-container">
                <div class="tabs-wrapper">
                    <button class="tab-btn active" data-tab="car-sale">
                        <i class="fas fa-car"></i>
                        <span class="tab-text">
                            <span class="en">Car Sale</span>
                            <span class="ar">بيع السيارات</span>
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="real-estate">
                        <i class="fas fa-home"></i>
                        <span class="tab-text">
                            <span class="en">Real Estate</span>
                            <span class="ar">العقارات</span>
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="electronics">
                        <i class="fas fa-tv"></i>
                        <span class="tab-text">
                            <span class="en">Electronics & Home</span>
                            <span class="ar">الإلكترونيات والمنزل</span>
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="jobs">
                        <i class="fas fa-briefcase"></i>
                        <span class="tab-text">
                            <span class="en">Jobs</span>
                            <span class="ar">الوظائف</span>
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="car-rent">
                        <i class="fas fa-key"></i>
                        <span class="tab-text">
                            <span class="en">Car Rent</span>
                            <span class="ar">تأجير السيارات</span>
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="car-services">
                        <i class="fas fa-wrench"></i>
                        <span class="tab-text">
                            <span class="en">Car Services</span>
                            <span class="ar">خدمات السيارات</span>
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="restaurants">
                        <i class="fas fa-utensils"></i>
                        <span class="tab-text">
                            <span class="en">Restaurants</span>
                            <span class="ar">المطاعم</span>
                        </span>
                    </button>
                    <button class="tab-btn" data-tab="other-services">
                        <i class="fas fa-cogs"></i>
                        <span class="tab-text">
                            <span class="en">Other Services</span>
                            <span class="ar">خدمات أخرى</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content-wrapper">
        <!-- Car Sale Tab -->
        <div class="tab-content active" id="car-sale-content">
            <div class="row">
                <!-- Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Search Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Make</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="toyota">
                                                <span class="item-text">Toyota</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="honda">
                                                <span class="item-text">Honda</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="bmw">
                                                <span class="item-text">BMW</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mercedes">
                                                <span class="item-text">Mercedes</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="audi">
                                                <span class="item-text">Audi</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="nissan">
                                                <span class="item-text">Nissan</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="hyundai">
                                                <span class="item-text">Hyundai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new make" id="new-make-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Model</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="camry">
                                                <span class="item-text">Camry</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="corolla">
                                                <span class="item-text">Corolla</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="civic">
                                                <span class="item-text">Civic</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="accord">
                                                <span class="item-text">Accord</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="x5">
                                                <span class="item-text">X5</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="c-class">
                                                <span class="item-text">C-Class</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new model" id="new-model-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                إعدادات البحث
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الماركة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="toyota">
                                                <span class="item-text">تويوتا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="honda">
                                                <span class="item-text">هوندا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="bmw">
                                                <span class="item-text">بي إم دبليو</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mercedes">
                                                <span class="item-text">مرسيدس</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="audi">
                                                <span class="item-text">أودي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="nissan">
                                                <span class="item-text">نيسان</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="hyundai">
                                                <span class="item-text">هيونداي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة ماركة جديدة" id="new-make-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الموديل</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="camry">
                                                <span class="item-text">كامري</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="corolla">
                                                <span class="item-text">كورولا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="civic">
                                                <span class="item-text">سيفيك</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="accord">
                                                <span class="item-text">أكورد</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="x5">
                                                <span class="item-text">إكس 5</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="c-class">
                                                <span class="item-text">سي كلاس</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة موديل جديد" id="new-model-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                 
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                Filter Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Trim</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="base">
                                                <span class="item-text">Base</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mid">
                                                <span class="item-text">Mid</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="high">
                                                <span class="item-text">High</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="premium">
                                                <span class="item-text">Premium</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new trim" id="new-trim-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Year</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="2024">
                                                <span class="item-text">2024</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2023">
                                                <span class="item-text">2023</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2022">
                                                <span class="item-text">2022</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2021">
                                                <span class="item-text">2021</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2020">
                                                <span class="item-text">2020</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new year" id="new-year-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">KM</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-10000">
                                                <span class="item-text">0 - 10,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="10000-50000">
                                                <span class="item-text">10,000 - 50,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="50000-100000">
                                                <span class="item-text">50,000 - 100,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100000+">
                                                <span class="item-text">100,000+</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new KM range" id="new-km-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-50000">
                                                <span class="item-text">$0 - $50,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="50000-100000">
                                                <span class="item-text">$50,000 - $100,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100000-200000">
                                                <span class="item-text">$100,000 - $200,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="200000+">
                                                <span class="item-text">$200,000+</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new price range" id="new-price-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                إعدادات الفلتر
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الفئة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="base">
                                                <span class="item-text">أساسي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mid">
                                                <span class="item-text">متوسط</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="high">
                                                <span class="item-text">عالي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="premium">
                                                <span class="item-text">فاخر</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة فئة جديدة" id="new-trim-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السنة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="2024">
                                                <span class="item-text">2024</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2023">
                                                <span class="item-text">2023</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2022">
                                                <span class="item-text">2022</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2021">
                                                <span class="item-text">2021</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2020">
                                                <span class="item-text">2020</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة سنة جديدة" id="new-year-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الكيلومترات</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-10000">
                                                <span class="item-text">0 - 10,000 كم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="10000-50000">
                                                <span class="item-text">10,000 - 50,000 كم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="50000-100000">
                                                <span class="item-text">50,000 - 100,000 كم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100000+">
                                                <span class="item-text">أكثر من 100,000 كم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نطاق كيلومترات جديد" id="new-km-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السعر</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-50000">
                                                <span class="item-text">$0 - $50,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="50000-100000">
                                                <span class="item-text">$50,000 - $100,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100000-200000">
                                                <span class="item-text">$100,000 - $200,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="200000+">
                                                <span class="item-text">أكثر من $200,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نطاق سعر جديد" id="new-price-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real Estate Tab -->
        <div class="tab-content" id="real-estate-content">
            <div class="row">
                <!-- Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Search Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Emirate</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">Dubai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">Abu Dhabi</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">Sharjah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">Ajman</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">Ras Al Khaimah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fujairah">
                                                <span class="item-text">Fujairah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="umm-al-quwain">
                                                <span class="item-text">Umm Al Quwain</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new emirate" id="new-emirate-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose District</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="downtown">
                                                <span class="item-text">Downtown</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="marina">
                                                <span class="item-text">Marina</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="jlt">
                                                <span class="item-text">JLT</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="business-bay">
                                                <span class="item-text">Business Bay</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="deira">
                                                <span class="item-text">Deira</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="bur-dubai">
                                                <span class="item-text">Bur Dubai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new district" id="new-district-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Property Type</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="apartment">
                                                <span class="item-text">Apartment</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="villa">
                                                <span class="item-text">Villa</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="townhouse">
                                                <span class="item-text">Townhouse</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="penthouse">
                                                <span class="item-text">Penthouse</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="studio">
                                                <span class="item-text">Studio</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new property type" id="new-property-type-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contract Type</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="sale">
                                                <span class="item-text">Sale</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="rent">
                                                <span class="item-text">Rent</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="lease">
                                                <span class="item-text">Lease</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new contract type" id="new-contract-type-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                إعدادات البحث
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الإمارة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">دبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">أبوظبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">الشارقة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">عجمان</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">رأس الخيمة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fujairah">
                                                <span class="item-text">الفجيرة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="umm-al-quwain">
                                                <span class="item-text">أم القيوين</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة إمارة جديدة" id="new-emirate-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر المنطقة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="downtown">
                                                <span class="item-text">وسط المدينة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="marina">
                                                <span class="item-text">المارينا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="jlt">
                                                <span class="item-text">أبراج بحيرة الجميرا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="business-bay">
                                                <span class="item-text">خليج الأعمال</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="deira">
                                                <span class="item-text">ديرة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="bur-dubai">
                                                <span class="item-text">بر دبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة منطقة جديدة" id="new-district-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">نوع العقار</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="apartment">
                                                <span class="item-text">شقة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="villa">
                                                <span class="item-text">فيلا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="townhouse">
                                                <span class="item-text">تاون هاوس</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="penthouse">
                                                <span class="item-text">بنت هاوس</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="studio">
                                                <span class="item-text">استوديو</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نوع عقار جديد" id="new-property-type-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">نوع العقد</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="sale">
                                                <span class="item-text">بيع</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="rent">
                                                <span class="item-text">إيجار</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="lease">
                                                <span class="item-text">تأجير</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نوع عقد جديد" id="new-contract-type-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="row">
                <!-- Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                Filter Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Type</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="residential">
                                                <span class="item-text">Residential</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="commercial">
                                                <span class="item-text">Commercial</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="industrial">
                                                <span class="item-text">Industrial</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new type" id="new-type-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">District</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="downtown">
                                                <span class="item-text">Downtown</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="marina">
                                                <span class="item-text">Marina</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="business-bay">
                                                <span class="item-text">Business Bay</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new district" id="new-filter-district-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contract</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="sale">
                                                <span class="item-text">Sale</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="rent">
                                                <span class="item-text">Rent</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new contract" id="new-filter-contract-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price Range</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-500000">
                                                <span class="item-text">AED 0 - 500,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="500000-1000000">
                                                <span class="item-text">AED 500,000 - 1,000,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="1000000-2000000">
                                                <span class="item-text">AED 1,000,000 - 2,000,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2000000+">
                                                <span class="item-text">AED 2,000,000+</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new price range" id="new-price-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                إعدادات الفلتر
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">النوع</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="residential">
                                                <span class="item-text">سكني</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="commercial">
                                                <span class="item-text">تجاري</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="industrial">
                                                <span class="item-text">صناعي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نوع جديد" id="new-type-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">المنطقة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="downtown">
                                                <span class="item-text">وسط المدينة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="marina">
                                                <span class="item-text">المارينا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="business-bay">
                                                <span class="item-text">خليج الأعمال</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة منطقة جديدة" id="new-filter-district-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">العقد</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="sale">
                                                <span class="item-text">بيع</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="rent">
                                                <span class="item-text">إيجار</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة عقد جديد" id="new-filter-contract-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">نطاق السعر</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-500000">
                                                <span class="item-text">0 - 500,000 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="500000-1000000">
                                                <span class="item-text">500,000 - 1,000,000 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="1000000-2000000">
                                                <span class="item-text">1,000,000 - 2,000,000 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2000000+">
                                                <span class="item-text">2,000,000+ درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نطاق سعر جديد" id="new-price-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Electronics & Home Tab -->
        <div class="tab-content" id="electronics-content">
            <div class="row">
                <!-- Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Search Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Emirate</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">Dubai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">Abu Dhabi</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">Sharjah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">Ajman</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new emirate" id="new-electronics-emirate-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Section Type</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="electronics">
                                                <span class="item-text">Electronics</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="home-appliances">
                                                <span class="item-text">Home Appliances</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="computers">
                                                <span class="item-text">Computers</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mobile-phones">
                                                <span class="item-text">Mobile Phones</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new section type" id="new-electronics-section-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                إعدادات البحث
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الإمارة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">دبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">أبوظبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">الشارقة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">عجمان</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة إمارة جديدة" id="new-electronics-emirate-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر نوع القسم</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="electronics">
                                                <span class="item-text">الإلكترونيات</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="home-appliances">
                                                <span class="item-text">الأجهزة المنزلية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="computers">
                                                <span class="item-text">أجهزة الكمبيوتر</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mobile-phones">
                                                <span class="item-text">الهواتف المحمولة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نوع قسم جديد" id="new-electronics-section-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="row">
                <!-- Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                Filter Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="smartphone">
                                                <span class="item-text">Smartphone</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="laptop">
                                                <span class="item-text">Laptop</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="tv">
                                                <span class="item-text">TV</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="refrigerator">
                                                <span class="item-text">Refrigerator</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new product" id="new-electronics-product-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Section</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="electronics">
                                                <span class="item-text">Electronics</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="home-appliances">
                                                <span class="item-text">Home Appliances</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new section" id="new-electronics-filter-section-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Price Range</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-500">
                                                <span class="item-text">0 - 500 AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="500-1000">
                                                <span class="item-text">500 - 1,000 AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="1000-5000">
                                                <span class="item-text">1,000 - 5,000 AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="5000+">
                                                <span class="item-text">5,000+ AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new price range" id="new-electronics-price-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                إعدادات الفلتر
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">المنتج</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="smartphone">
                                                <span class="item-text">هاتف ذكي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="laptop">
                                                <span class="item-text">لابتوب</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="tv">
                                                <span class="item-text">تلفزيون</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="refrigerator">
                                                <span class="item-text">ثلاجة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة منتج جديد" id="new-electronics-product-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">القسم</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="electronics">
                                                <span class="item-text">الإلكترونيات</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="home-appliances">
                                                <span class="item-text">الأجهزة المنزلية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة قسم جديد" id="new-electronics-filter-section-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">نطاق السعر</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-500">
                                                <span class="item-text">0 - 500 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="500-1000">
                                                <span class="item-text">500 - 1,000 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="1000-5000">
                                                <span class="item-text">1,000 - 5,000 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="5000+">
                                                <span class="item-text">5,000+ درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نطاق سعر جديد" id="new-electronics-price-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="jobs-content">
            <div class="row">
                <!-- Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Search Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Emirate</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">Dubai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">Abu Dhabi</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">Sharjah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">Ajman</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">Ras Al Khaimah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fujairah">
                                                <span class="item-text">Fujairah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new emirate" id="new-emirate-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Category Type</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="full-time">
                                                <span class="item-text">Full Time</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="part-time">
                                                <span class="item-text">Part Time</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="contract">
                                                <span class="item-text">Contract</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="freelance">
                                                <span class="item-text">Freelance</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="internship">
                                                <span class="item-text">Internship</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="remote">
                                                <span class="item-text">Remote</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new category type" id="new-category-type-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                إعدادات البحث
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الإمارة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">دبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">أبوظبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">الشارقة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">عجمان</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">رأس الخيمة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fujairah">
                                                <span class="item-text">الفجيرة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة إمارة جديدة" id="new-emirate-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر نوع الفئة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="full-time">
                                                <span class="item-text">دوام كامل</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="part-time">
                                                <span class="item-text">دوام جزئي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="contract">
                                                <span class="item-text">عقد</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="freelance">
                                                <span class="item-text">عمل حر</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="internship">
                                                <span class="item-text">تدريب</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="remote">
                                                <span class="item-text">عن بُعد</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نوع فئة جديد" id="new-category-type-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                Filter Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="technology">
                                                <span class="item-text">Technology</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="healthcare">
                                                <span class="item-text">Healthcare</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="finance">
                                                <span class="item-text">Finance</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="education">
                                                <span class="item-text">Education</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="marketing">
                                                <span class="item-text">Marketing</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sales">
                                                <span class="item-text">Sales</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new category" id="new-filter-category-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Section</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="software-development">
                                                <span class="item-text">Software Development</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="data-science">
                                                <span class="item-text">Data Science</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="nursing">
                                                <span class="item-text">Nursing</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="accounting">
                                                <span class="item-text">Accounting</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="teaching">
                                                <span class="item-text">Teaching</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="digital-marketing">
                                                <span class="item-text">Digital Marketing</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new section" id="new-filter-section-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                إعدادات الفلتر
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الفئة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="technology">
                                                <span class="item-text">التكنولوجيا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="healthcare">
                                                <span class="item-text">الرعاية الصحية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="finance">
                                                <span class="item-text">المالية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="education">
                                                <span class="item-text">التعليم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="marketing">
                                                <span class="item-text">التسويق</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sales">
                                                <span class="item-text">المبيعات</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة فئة جديدة" id="new-filter-category-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">القسم</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="software-development">
                                                <span class="item-text">تطوير البرمجيات</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="data-science">
                                                <span class="item-text">علم البيانات</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="nursing">
                                                <span class="item-text">التمريض</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="accounting">
                                                <span class="item-text">المحاسبة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="teaching">
                                                <span class="item-text">التدريس</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="digital-marketing">
                                                <span class="item-text">التسويق الرقمي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة قسم جديد" id="new-filter-section-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="car-rent-content">
            <div class="row">
                <!-- Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Car Rental Search Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Make</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="toyota">
                                                <span class="item-text">Toyota</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="honda">
                                                <span class="item-text">Honda</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="bmw">
                                                <span class="item-text">BMW</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mercedes">
                                                <span class="item-text">Mercedes</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="audi">
                                                <span class="item-text">Audi</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="nissan">
                                                <span class="item-text">Nissan</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="hyundai">
                                                <span class="item-text">Hyundai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new make" id="new-make-input-rent">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Model</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="camry">
                                                <span class="item-text">Camry</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="corolla">
                                                <span class="item-text">Corolla</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="civic">
                                                <span class="item-text">Civic</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="accord">
                                                <span class="item-text">Accord</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="x5">
                                                <span class="item-text">X5</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="c-class">
                                                <span class="item-text">C-Class</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new model" id="new-model-input-rent">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                إعدادات البحث عن تأجير السيارات
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الماركة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="toyota">
                                                <span class="item-text">تويوتا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="honda">
                                                <span class="item-text">هوندا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="bmw">
                                                <span class="item-text">بي إم دبليو</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mercedes">
                                                <span class="item-text">مرسيدس</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="audi">
                                                <span class="item-text">أودي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="nissan">
                                                <span class="item-text">نيسان</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="hyundai">
                                                <span class="item-text">هيونداي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="أضف ماركة جديدة" id="new-make-input-rent-ar">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الموديل</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="camry">
                                                <span class="item-text">كامري</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="corolla">
                                                <span class="item-text">كورولا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="civic">
                                                <span class="item-text">سيفيك</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="accord">
                                                <span class="item-text">أكورد</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="x5">
                                                <span class="item-text">إكس 5</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="c-class">
                                                <span class="item-text">سي كلاس</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="أضف موديل جديد" id="new-model-input-rent-ar">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
             <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                Filter Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Trim</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="base">
                                                <span class="item-text">Base</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mid">
                                                <span class="item-text">Mid</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="high">
                                                <span class="item-text">High</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="premium">
                                                <span class="item-text">Premium</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new trim" id="new-trim-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Year</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="2024">
                                                <span class="item-text">2024</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2023">
                                                <span class="item-text">2023</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2022">
                                                <span class="item-text">2022</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2021">
                                                <span class="item-text">2021</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2020">
                                                <span class="item-text">2020</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new year" id="new-year-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">KM</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-10000">
                                                <span class="item-text">0 - 10,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="10000-50000">
                                                <span class="item-text">10,000 - 50,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="50000-100000">
                                                <span class="item-text">50,000 - 100,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100000+">
                                                <span class="item-text">100,000+</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new KM range" id="new-km-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-50000">
                                                <span class="item-text">$0 - $50,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="50000-100000">
                                                <span class="item-text">$50,000 - $100,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100000-200000">
                                                <span class="item-text">$100,000 - $200,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="200000+">
                                                <span class="item-text">$200,000+</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new price range" id="new-price-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                إعدادات الفلتر
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الفئة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="base">
                                                <span class="item-text">أساسي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="mid">
                                                <span class="item-text">متوسط</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="high">
                                                <span class="item-text">عالي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="premium">
                                                <span class="item-text">فاخر</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة فئة جديدة" id="new-trim-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السنة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="2024">
                                                <span class="item-text">2024</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2023">
                                                <span class="item-text">2023</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2022">
                                                <span class="item-text">2022</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2021">
                                                <span class="item-text">2021</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="2020">
                                                <span class="item-text">2020</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة سنة جديدة" id="new-year-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الكيلومترات</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-10000">
                                                <span class="item-text">0 - 10,000 كم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="10000-50000">
                                                <span class="item-text">10,000 - 50,000 كم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="50000-100000">
                                                <span class="item-text">50,000 - 100,000 كم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100000+">
                                                <span class="item-text">أكثر من 100,000 كم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نطاق كيلومترات جديد" id="new-km-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السعر</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-50000">
                                                <span class="item-text">$0 - $50,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="50000-100000">
                                                <span class="item-text">$50,000 - $100,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100000-200000">
                                                <span class="item-text">$100,000 - $200,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="200000+">
                                                <span class="item-text">أكثر من $200,000</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نطاق سعر جديد" id="new-price-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="tab-content" id="car-services-content">
            <div class="row">
                <!-- Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Search Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Emirate</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">Dubai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">Abu Dhabi</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">Sharjah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">Ajman</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">Ras Al Khaimah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fujairah">
                                                <span class="item-text">Fujairah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="umm-al-quwain">
                                                <span class="item-text">Umm Al Quwain</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new emirate" id="new-emirate-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Service Type</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="oil-change">
                                                <span class="item-text">Oil Change</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="tire-service">
                                                <span class="item-text">Tire Service</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="brake-service">
                                                <span class="item-text">Brake Service</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="car-wash">
                                                <span class="item-text">Car Wash</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ac-service">
                                                <span class="item-text">AC Service</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="battery-service">
                                                <span class="item-text">Battery Service</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new service type" id="new-service-type-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                إعدادات البحث
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الإمارة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">دبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">أبوظبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">الشارقة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">عجمان</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">رأس الخيمة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fujairah">
                                                <span class="item-text">الفجيرة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="umm-al-quwain">
                                                <span class="item-text">أم القيوين</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة إمارة جديدة" id="new-emirate-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر نوع الخدمة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="oil-change">
                                                <span class="item-text">تغيير الزيت</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="tire-service">
                                                <span class="item-text">خدمة الإطارات</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="brake-service">
                                                <span class="item-text">خدمة الفرامل</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="car-wash">
                                                <span class="item-text">غسيل السيارات</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ac-service">
                                                <span class="item-text">خدمة التكييف</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="battery-service">
                                                <span class="item-text">خدمة البطارية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نوع خدمة جديد" id="new-service-type-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Settings -->
            <div class="row">
                <!-- English Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                Filter Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <!-- Service Type and District Filters -->
                                <div class="col-md-6">
                                    <!-- Service Type Filter -->
                                    <div class="mb-4">
                                        <h6 class="filter-title">Service Type</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="oil-change">
                                                    <span class="item-text">Oil Change</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="tire-service">
                                                    <span class="item-text">Tire Service</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="brake-service">
                                                    <span class="item-text">Brake Service</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="car-wash">
                                                    <span class="item-text">Car Wash</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="ac-service">
                                                    <span class="item-text">AC Service</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Add new service type" id="new-filter-service-type-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- District Filter -->
                                    <div class="mb-4">
                                        <h6 class="filter-title">District</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="downtown">
                                                    <span class="item-text">Downtown</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="marina">
                                                    <span class="item-text">Marina</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="jumeirah">
                                                    <span class="item-text">Jumeirah</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="deira">
                                                    <span class="item-text">Deira</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="bur-dubai">
                                                    <span class="item-text">Bur Dubai</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Add new district" id="new-district-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Filter -->
                            <div class="mb-4">
                                <h6 class="filter-title">Price Range</h6>
                                <div class="static-list-container">
                                    <div class="static-list">
                                        <div class="list-item" data-value="0-100">
                                            <span class="item-text">0 - 100 AED</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-item" data-value="100-300">
                                            <span class="item-text">100 - 300 AED</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-item" data-value="300-500">
                                            <span class="item-text">300 - 500 AED</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-item" data-value="500-1000">
                                            <span class="item-text">500 - 1000 AED</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-item" data-value="1000+">
                                            <span class="item-text">1000+ AED</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-item-section fixed-footer">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Add new price range" id="new-price-input">
                                            <button class="btn btn-success add-item-btn" type="button">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                إعدادات الفلاتر
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Service Type and District Filters Arabic - Row 1 -->
                            <div class="row">
                                <!-- Service Type Filter Arabic -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="filter-title">نوع الخدمة</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="oil-change">
                                                    <span class="item-text">تغيير الزيت</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="tire-service">
                                                    <span class="item-text">خدمة الإطارات</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="brake-service">
                                                    <span class="item-text">خدمة الفرامل</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="car-wash">
                                                    <span class="item-text">غسيل السيارات</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="ac-service">
                                                    <span class="item-text">خدمة التكييف</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="إضافة نوع خدمة جديد" id="new-filter-service-type-ar-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- District Filter Arabic -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="filter-title">المنطقة</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="downtown">
                                                    <span class="item-text">وسط المدينة</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="marina">
                                                    <span class="item-text">المارينا</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="jumeirah">
                                                    <span class="item-text">الجميرا</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="deira">
                                                    <span class="item-text">ديرة</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="bur-dubai">
                                                    <span class="item-text">بر دبي</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="إضافة منطقة جديدة" id="new-district-ar-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Filter Arabic -->
                            <div class="mb-4">
                                <h6 class="filter-title">نطاق السعر</h6>
                                <div class="static-list-container">
                                    <div class="static-list">
                                        <div class="list-item" data-value="0-100">
                                            <span class="item-text">0 - 100 درهم</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-item" data-value="100-300">
                                            <span class="item-text">100 - 300 درهم</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-item" data-value="300-500">
                                            <span class="item-text">300 - 500 درهم</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-item" data-value="500-1000">
                                            <span class="item-text">500 - 1000 درهم</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="list-item" data-value="1000+">
                                            <span class="item-text">1000+ درهم</span>
                                            <div class="item-actions">
                                                <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-item-section fixed-footer">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="إضافة نطاق سعر جديد" id="new-price-ar-input">
                                            <button class="btn btn-success add-item-btn" type="button">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="restaurants-content">
            <div class="row">
                <!-- Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Search Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Emirate and District - Row 1 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Emirate</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">Dubai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">Abu Dhabi</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">Sharjah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">Ajman</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">Ras Al Khaimah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new emirate" id="new-emirate-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose District</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="downtown">
                                                <span class="item-text">Downtown</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="marina">
                                                <span class="item-text">Marina</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="jumeirah">
                                                <span class="item-text">Jumeirah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="deira">
                                                <span class="item-text">Deira</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="bur-dubai">
                                                <span class="item-text">Bur Dubai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new district" id="new-district-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Category Type - Row 2 -->
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Choose Category Type</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="fast-food">
                                                <span class="item-text">Fast Food</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fine-dining">
                                                <span class="item-text">Fine Dining</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="cafe">
                                                <span class="item-text">Cafe</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="buffet">
                                                <span class="item-text">Buffet</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="delivery">
                                                <span class="item-text">Delivery</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new category type" id="new-category-type-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                إعدادات البحث
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Emirate and District Arabic - Row 1 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الإمارة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">دبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">أبوظبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">الشارقة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">عجمان</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">رأس الخيمة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة إمارة جديدة" id="new-emirate-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر المنطقة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="downtown">
                                                <span class="item-text">وسط المدينة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="marina">
                                                <span class="item-text">المارينا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="jumeirah">
                                                <span class="item-text">الجميرا</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="deira">
                                                <span class="item-text">ديرة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="bur-dubai">
                                                <span class="item-text">بر دبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة منطقة جديدة" id="new-district-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Category Type Arabic - Row 2 -->
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">اختر نوع الفئة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="fast-food">
                                                <span class="item-text">وجبات سريعة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fine-dining">
                                                <span class="item-text">مطاعم راقية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="cafe">
                                                <span class="item-text">مقهى</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="buffet">
                                                <span class="item-text">بوفيه مفتوح</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="delivery">
                                                <span class="item-text">توصيل</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نوع فئة جديد" id="new-category-type-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Settings Row -->
            <div class="row">
                <!-- English Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                Filter Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- District and Price Filters - Row 1 -->
                            <div class="row">
                                <!-- District Filter -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="filter-title">District</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="downtown">
                                                    <span class="item-text">Downtown</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="marina">
                                                    <span class="item-text">Marina</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="jumeirah">
                                                    <span class="item-text">Jumeirah</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="deira">
                                                    <span class="item-text">Deira</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="bur-dubai">
                                                    <span class="item-text">Bur Dubai</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Add new district" id="new-filter-district-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Filter -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="filter-title">Price Range</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="0-50">
                                                    <span class="item-text">0 - 50 AED</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="50-100">
                                                    <span class="item-text">50 - 100 AED</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="100-200">
                                                    <span class="item-text">100 - 200 AED</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="200-500">
                                                    <span class="item-text">200 - 500 AED</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="500+">
                                                    <span class="item-text">500+ AED</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Add new price range" id="new-filter-price-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Category Filter - Row 2 -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h6 class="filter-title">Category</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="fast-food">
                                                    <span class="item-text">Fast Food</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="fine-dining">
                                                    <span class="item-text">Fine Dining</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="cafe">
                                                    <span class="item-text">Cafe</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="buffet">
                                                    <span class="item-text">Buffet</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="delivery">
                                                    <span class="item-text">Delivery</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Add new category" id="new-filter-category-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                إعدادات الفلاتر
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- District and Price Filters Arabic - Row 1 -->
                            <div class="row">
                                <!-- District Filter Arabic -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="filter-title">المنطقة</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="downtown">
                                                    <span class="item-text">وسط المدينة</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="marina">
                                                    <span class="item-text">المارينا</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="jumeirah">
                                                    <span class="item-text">الجميرا</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="deira">
                                                    <span class="item-text">ديرة</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="bur-dubai">
                                                    <span class="item-text">بر دبي</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="إضافة منطقة جديدة" id="new-filter-district-ar-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Filter Arabic -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6 class="filter-title">نطاق السعر</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="0-50">
                                                    <span class="item-text">0 - 50 درهم</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="50-100">
                                                    <span class="item-text">50 - 100 درهم</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="100-200">
                                                    <span class="item-text">100 - 200 درهم</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="200-500">
                                                    <span class="item-text">200 - 500 درهم</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="500+">
                                                    <span class="item-text">500+ درهم</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="إضافة نطاق سعر جديد" id="new-filter-price-ar-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Category Filter Arabic - Row 2 -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h6 class="filter-title">الفئة</h6>
                                        <div class="static-list-container">
                                            <div class="static-list">
                                                <div class="list-item" data-value="fast-food">
                                                    <span class="item-text">وجبات سريعة</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="fine-dining">
                                                    <span class="item-text">مطاعم راقية</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="cafe">
                                                    <span class="item-text">مقهى</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="buffet">
                                                    <span class="item-text">بوفيه مفتوح</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="list-item" data-value="delivery">
                                                    <span class="item-text">توصيل</span>
                                                    <div class="item-actions">
                                                        <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-item-section fixed-footer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="إضافة فئة جديدة" id="new-filter-category-ar-input">
                                                    <button class="btn btn-success add-item-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="other-services-content">
            <div class="row">
                <!-- Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                Search Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Emirate</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">Dubai</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">Abu Dhabi</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">Sharjah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">Ajman</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">Ras Al Khaimah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fujairah">
                                                <span class="item-text">Fujairah</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="umm-al-quwain">
                                                <span class="item-text">Umm Al Quwain</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new emirate" id="new-emirate-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Choose Section Type</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="health">
                                                <span class="item-text">Health Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="education">
                                                <span class="item-text">Education Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="beauty">
                                                <span class="item-text">Beauty & Wellness</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="cleaning">
                                                <span class="item-text">Cleaning Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="maintenance">
                                                <span class="item-text">Maintenance Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="delivery">
                                                <span class="item-text">Delivery Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new section type" id="new-section-type-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Search Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card search-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                إعدادات البحث
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر الإمارة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="dubai">
                                                <span class="item-text">دبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="abu-dhabi">
                                                <span class="item-text">أبوظبي</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="sharjah">
                                                <span class="item-text">الشارقة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ajman">
                                                <span class="item-text">عجمان</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="ras-al-khaimah">
                                                <span class="item-text">رأس الخيمة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="fujairah">
                                                <span class="item-text">الفجيرة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="umm-al-quwain">
                                                <span class="item-text">أم القيوين</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة إمارة جديدة" id="new-emirate-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">اختر نوع القسم</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="health">
                                                <span class="item-text">الخدمات الصحية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="education">
                                                <span class="item-text">الخدمات التعليمية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="beauty">
                                                <span class="item-text">الجمال والعافية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="cleaning">
                                                <span class="item-text">خدمات التنظيف</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="maintenance">
                                                <span class="item-text">خدمات الصيانة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="delivery">
                                                <span class="item-text">خدمات التوصيل</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نوع قسم جديد" id="new-section-type-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                Filter Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label">Section</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="health">
                                                <span class="item-text">Health Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="education">
                                                <span class="item-text">Education Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="beauty">
                                                <span class="item-text">Beauty & Wellness</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="cleaning">
                                                <span class="item-text">Cleaning Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="maintenance">
                                                <span class="item-text">Maintenance Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="delivery">
                                                <span class="item-text">Delivery Services</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new section" id="new-section-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label">Price</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-100">
                                                <span class="item-text">0 - 100 AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100-500">
                                                <span class="item-text">100 - 500 AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="500-1000">
                                                <span class="item-text">500 - 1000 AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="1000-5000">
                                                <span class="item-text">1000 - 5000 AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="5000+">
                                                <span class="item-text">5000+ AED</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new price range" id="new-price-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Service</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="consultation">
                                                <span class="item-text">Consultation</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="installation">
                                                <span class="item-text">Installation</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="repair">
                                                <span class="item-text">Repair</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="maintenance">
                                                <span class="item-text">Maintenance</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="delivery">
                                                <span class="item-text">Delivery</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="emergency">
                                                <span class="item-text">Emergency Service</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Add new service" id="new-service-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Arabic Filter Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card filter-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                إعدادات الفلاتر
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label">القسم</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="health">
                                                <span class="item-text">الخدمات الصحية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="education">
                                                <span class="item-text">الخدمات التعليمية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="beauty">
                                                <span class="item-text">الجمال والعافية</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="cleaning">
                                                <span class="item-text">خدمات التنظيف</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="maintenance">
                                                <span class="item-text">خدمات الصيانة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="delivery">
                                                <span class="item-text">خدمات التوصيل</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة قسم جديد" id="new-section-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label">السعر</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="0-100">
                                                <span class="item-text">0 - 100 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="100-500">
                                                <span class="item-text">100 - 500 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="500-1000">
                                                <span class="item-text">500 - 1000 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="1000-5000">
                                                <span class="item-text">1000 - 5000 درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="5000+">
                                                <span class="item-text">5000+ درهم</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة نطاق سعر جديد" id="new-price-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">الخدمة</label>
                                    <div class="static-list-container">
                                        <div class="static-list">
                                            <div class="list-item" data-value="consultation">
                                                <span class="item-text">استشارة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="installation">
                                                <span class="item-text">تركيب</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="repair">
                                                <span class="item-text">إصلاح</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="maintenance">
                                                <span class="item-text">صيانة</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="delivery">
                                                <span class="item-text">توصيل</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-item" data-value="emergency">
                                                <span class="item-text">خدمة طوارئ</span>
                                                <div class="item-actions">
                                                    <button class="btn btn-sm btn-warning edit-btn" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-btn" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-item-section fixed-footer">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="إضافة خدمة جديدة" id="new-service-ar-input">
                                                <button class="btn btn-success add-item-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
:root {
    --primary-blue: #3490dc;
    --secondary-blue: #2779bd;
    --dark-gray: #4a5568;
    --light-gray: #f7fafc;
    --border-color: #e2e8f0;
    --shadow-light: 0 2px 4px rgba(0,0,0,0.1);
    --shadow-medium: 0 4px 6px rgba(0,0,0,0.1);
    --shadow-heavy: 0 10px 15px rgba(0,0,0,0.1);
}

/* Tabs Styling */
.tabs-container {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    border-radius: 15px;
    padding: 8px;
    box-shadow: var(--shadow-heavy);
    margin-bottom: 2rem;
}

.tabs-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
}

.tab-btn {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    border-radius: 10px;
    padding: 12px 16px;
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 140px;
    justify-content: center;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.tab-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.tab-btn:hover::before {
    left: 100%;
}

.tab-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.tab-btn.active {
    background: white;
    color: var(--primary-blue);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-1px);
}

.tab-btn i {
    font-size: 1.1rem;
}

.tab-text {
    display: flex;
    flex-direction: column;
    align-items: center;
    line-height: 1.2;
}

.tab-text .en {
    font-size: 0.9rem;
    font-weight: 600;
}

.tab-text .ar {
    font-size: 0.75rem;
    opacity: 0.8;
}

/* Tab Content */
.tab-content-wrapper {
    position: relative;
}

.tab-content {
    display: none;
    animation: fadeInUp 0.5s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Cards Styling */
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: var(--shadow-medium);
    transition: all 0.3s ease;
    position: relative;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-heavy);
}

.search-card {
    border-left: 4px solid var(--primary-blue);
}

.filter-card {
    border-left: 4px solid var(--dark-gray);
}

.card-header {
    border-bottom: none;
    padding: 1.25rem;
    position: relative;
    overflow: hidden;
}

.card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
    pointer-events: none;
}

.card-body {
    /* padding: 1.5rem; */
    background: linear-gradient(135deg, #ffffff, #f8fafc);
}

/* Form Elements */
.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid var(--border-color);
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 0.2rem rgba(52, 144, 220, 0.25);
    transform: translateY(-1px);
}

.form-label {
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .tabs-wrapper {
        flex-direction: column;
        align-items: stretch;
    }
    
    .tab-btn {
        min-width: auto;
        width: 100%;
    }
    
    .tab-text {
        flex-direction: row;
        gap: 10px;
    }
    
    .tab-text .en, .tab-text .ar {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .tabs-container {
        padding: 6px;
    }
    
    .tab-btn {
        padding: 10px 12px;
        font-size: 0.85rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}

/* General Styles */
.breadcrumb {
    background: rgba(52, 144, 220, 0.1);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    border: 1px solid rgba(52, 144, 220, 0.2);
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: var(--primary-blue);
}

.breadcrumb-item a {
    color: var(--primary-blue);
    text-decoration: none;
    font-weight: 500;
}

.text-primary {
    color: var(--primary-blue) !important;
}

.bg-primary {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
}

.bg-secondary {
    background: linear-gradient(135deg, var(--dark-gray), #2d3748) !important;
}

/* Loading Animation */
.tab-btn {
    position: relative;
}

.tab-btn.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Placeholder Content Styling */
.tab-content .text-center {
    background: linear-gradient(135deg, #f8fafc, #ffffff);
    border-radius: 15px;
    padding: 3rem 2rem;
    box-shadow: var(--shadow-light);
    border: 2px dashed var(--border-color);
}

.tab-content .text-center i {
    color: var(--primary-blue);
    margin-bottom: 1rem;
}

.tab-content .text-center h4 {
    color: var(--dark-gray);
    margin-bottom: 0.5rem;
}
/* Static List Styling */
.static-list-container {
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: white;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: var(--shadow-light);
}

.static-list {
    padding: 0;
    margin: 0;
}

.list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
}

.list-item:last-child {
    border-bottom: none;
}

.list-item:hover {
    background-color: var(--light-gray);
    transform: translateX(2px);
}

.list-item.selected {
    background-color: rgba(52, 144, 220, 0.1);
    border-left: 4px solid var(--primary-blue);
    font-weight: 600;
}

.item-text {
    font-weight: 500;
    color: var(--dark-gray);
    flex-grow: 1;
    transition: color 0.2s ease;
}

.list-item.selected .item-text {
    color: var(--primary-blue);
}

.item-actions {
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.list-item:hover .item-actions {
    opacity: 1;
}

.edit-btn, .delete-btn {
    padding: 4px 8px;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    height: 30px;
}

.edit-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.delete-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.add-item-section.fixed-footer {
    position: sticky;
    bottom: 0;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-top: 2px solid var(--primary-blue);
    box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
    z-index: 10;
    margin-top: auto;
}
.add-item-btn {
    border-radius: 0 8px 8px 0;
    transition: all 0.2s ease;
    font-weight: 600;
}

.add-item-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Edit Mode Styling */
.list-item.edit-mode {
    background-color: #fff3cd;
    border-left: 4px solid #ffc107;
}

.list-item.edit-mode .item-text {
    display: none;
}

.edit-input {
    border: 1px solid #ffc107;
    border-radius: 4px;
    padding: 4px 8px;
    font-size: 14px;
    flex-grow: 1;
    margin-right: 8px;
}

.edit-actions {
    display: flex;
    gap: 4px;
}

.save-btn, .cancel-btn {
    padding: 4px 8px;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    min-width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.save-btn {
    background-color: #28a745;
    color: white;
}

.cancel-btn {
    background-color: #6c757d;
    color: white;
}

@media (max-width: 768px) {
    .static-list-container {
        max-height: 200px;
    }
    
    .list-item {
        padding: 10px 12px;
    }
    
    .item-actions {
        opacity: 1;
    }
    
    .edit-btn, .delete-btn {
        min-width: 25px;
        height: 25px;
        font-size: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    // Tab functionality
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Add loading state
            this.classList.add('loading');
            
            setTimeout(() => {
                // Remove active class from all tabs and contents
                tabBtns.forEach(b => b.classList.remove('active', 'loading'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                const targetContent = document.getElementById(targetTab + '-content');
                if (targetContent) {
                    targetContent.classList.add('active');
                }
            }, 300);
        });
    });
    
    // Add ripple effect
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
                z-index: 1;
            `;
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Static List functionality
    initializeStaticLists();
});

function initializeStaticLists() {
    // Handle list item selection
    document.addEventListener('click', function(e) {
        if (e.target.closest('.list-item') && !e.target.closest('.item-actions')) {
            const listItem = e.target.closest('.list-item');
            const container = listItem.closest('.static-list');
            
            // Remove selected class from siblings
            container.querySelectorAll('.list-item').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Add selected class to clicked item
            listItem.classList.add('selected');
        }
    });
    
    // Handle edit button
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-btn')) {
            e.stopPropagation();
            const listItem = e.target.closest('.list-item');
            const itemText = listItem.querySelector('.item-text');
            const currentText = itemText.textContent;
            
            // Enter edit mode
            listItem.classList.add('edit-mode');
            
            // Create edit input
            const editInput = document.createElement('input');
            editInput.type = 'text';
            editInput.className = 'edit-input';
            editInput.value = currentText;
            
            // Create edit actions
            const editActions = document.createElement('div');
            editActions.className = 'edit-actions';
            
            const saveBtn = document.createElement('button');
            saveBtn.className = 'btn save-btn';
            saveBtn.innerHTML = '<i class="fas fa-check"></i>';
            saveBtn.title = 'Save';
            
            const cancelBtn = document.createElement('button');
            cancelBtn.className = 'btn cancel-btn';
            cancelBtn.innerHTML = '<i class="fas fa-times"></i>';
            cancelBtn.title = 'Cancel';
            
            editActions.appendChild(saveBtn);
            editActions.appendChild(cancelBtn);
            
            // Replace item actions with edit input and actions
            const itemActions = listItem.querySelector('.item-actions');
            itemActions.style.display = 'none';
            listItem.insertBefore(editInput, itemActions);
            listItem.insertBefore(editActions, itemActions);
            
            editInput.focus();
            editInput.select();
            
            // Save functionality
            function saveEdit() {
                const newText = editInput.value.trim();
                if (newText && newText !== currentText) {
                    const container = listItem.closest('.static-list-container');
                    const listId = getListIdentifier(container);
                    
                    // Save edit to localStorage
                    saveEditedItem(listId, currentText, newText);
                    
                    itemText.textContent = newText;
                    listItem.classList.add('edited-item');
                    console.log('Saving:', newText);
                }
                exitEditMode();
            }
            
            // Cancel functionality
            function exitEditMode() {
                listItem.classList.remove('edit-mode');
                editInput.remove();
                editActions.remove();
                itemActions.style.display = 'flex';
            }
            
            // Event listeners
            saveBtn.addEventListener('click', saveEdit);
            cancelBtn.addEventListener('click', exitEditMode);
            editInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') saveEdit();
                if (e.key === 'Escape') exitEditMode();
            });
        }
    });
    
    // Handle delete button
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            e.stopPropagation();
            const listItem = e.target.closest('.list-item');
            const itemText = listItem.querySelector('.item-text').textContent;
            
            if (confirm(`Are you sure you want to delete "${itemText}"?`)) {
                listItem.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    // If it's a custom item, remove from localStorage
                    if (listItem.hasAttribute('data-custom')) {
                        const container = listItem.closest('.static-list-container');
                        const listId = getListIdentifier(container);
                        removeCustomItem(listId, itemText);
                    }
                    
                    // If it's an edited item, remove the edit from localStorage
                    if (listItem.classList.contains('edited-item')) {
                        const container = listItem.closest('.static-list-container');
                        const listId = getListIdentifier(container);
                        // Find original text by checking localStorage
                        const editedItems = JSON.parse(localStorage.getItem('editedFilterItems') || '{}');
                        if (editedItems[listId]) {
                            Object.keys(editedItems[listId]).forEach(originalText => {
                                if (editedItems[listId][originalText] === itemText) {
                                    removeEditedItem(listId, originalText);
                                }
                            });
                        }
                    }
                    
                    listItem.remove();
                    console.log('Deleting:', itemText);
                }, 300);
            }
        }
    });
    
    // Handle add item button
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-item-btn')) {
            const addSection = e.target.closest('.add-item-section');
            const input = addSection.querySelector('input');
            const newText = input.value.trim();
            
            if (newText) {
                const container = addSection.closest('.static-list-container');
                const staticList = container.querySelector('.static-list');
                
                // Get the list identifier for localStorage
                const listId = getListIdentifier(container);
                
                // Create new list item
                const newItem = document.createElement('div');
                newItem.className = 'list-item custom-item';
                newItem.setAttribute('data-value', newText.toLowerCase().replace(/\s+/g, '-'));
                newItem.setAttribute('data-custom', 'true');
                
                newItem.innerHTML = `
                    <span class="item-text">${newText}</span>
                    <div class="item-actions">
                        <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                
                // Add animation
                newItem.style.animation = 'slideIn 0.3s ease-out';
                
                // Append to list
                staticList.appendChild(newItem);
                
                // Save to localStorage
                saveCustomItem(listId, newText);
                
                // Clear input
                input.value = '';
                
                console.log('Adding:', newText);
            }
        }
    });
    
    // Handle enter key in add input
    document.addEventListener('keypress', function(e) {
        if (e.target.matches('.add-item-section input') && e.key === 'Enter') {
            const addBtn = e.target.closest('.add-item-section').querySelector('.add-item-btn');
            addBtn.click();
        }
    });
    
    // LocalStorage functions
    function getListIdentifier(container) {
        // Get a unique identifier for the list based on its input ID or nearby labels
        const input = container.querySelector('input');
        if (input && input.id) {
            return input.id;
        }
        
        // Fallback: use the label text or placeholder
        const label = container.closest('.mb-3, .mb-4')?.querySelector('label');
        if (label) {
            return label.textContent.trim().toLowerCase().replace(/\s+/g, '_');
        }
        
        const placeholder = input?.placeholder;
        if (placeholder) {
            return placeholder.toLowerCase().replace(/\s+/g, '_');
        }
        
        return 'default_list';
    }
    
    function saveCustomItem(listId, itemText) {
        let customItems = JSON.parse(localStorage.getItem('customFilterItems') || '{}');
        if (!customItems[listId]) {
            customItems[listId] = [];
        }
        if (!customItems[listId].includes(itemText)) {
            customItems[listId].push(itemText);
            localStorage.setItem('customFilterItems', JSON.stringify(customItems));
        }
    }
    
    function removeCustomItem(listId, itemText) {
        let customItems = JSON.parse(localStorage.getItem('customFilterItems') || '{}');
        if (customItems[listId]) {
            customItems[listId] = customItems[listId].filter(item => item !== itemText);
            if (customItems[listId].length === 0) {
                delete customItems[listId];
            }
            localStorage.setItem('customFilterItems', JSON.stringify(customItems));
        }
    }
    
    function saveEditedItem(listId, originalText, newText) {
        let editedItems = JSON.parse(localStorage.getItem('editedFilterItems') || '{}');
        if (!editedItems[listId]) {
            editedItems[listId] = {};
        }
        editedItems[listId][originalText] = newText;
        localStorage.setItem('editedFilterItems', JSON.stringify(editedItems));
    }
    
    function getEditedText(listId, originalText) {
        const editedItems = JSON.parse(localStorage.getItem('editedFilterItems') || '{}');
        return editedItems[listId] && editedItems[listId][originalText] ? editedItems[listId][originalText] : originalText;
    }
    
    function removeEditedItem(listId, originalText) {
        let editedItems = JSON.parse(localStorage.getItem('editedFilterItems') || '{}');
        if (editedItems[listId] && editedItems[listId][originalText]) {
            delete editedItems[listId][originalText];
            if (Object.keys(editedItems[listId]).length === 0) {
                delete editedItems[listId];
            }
            localStorage.setItem('editedFilterItems', JSON.stringify(editedItems));
        }
    }
    
    function loadCustomItems() {
        const customItems = JSON.parse(localStorage.getItem('customFilterItems') || '{}');
        const editedItems = JSON.parse(localStorage.getItem('editedFilterItems') || '{}');
        
        // Load custom items
        Object.keys(customItems).forEach(listId => {
            const container = document.querySelector(`#${listId}`)?.closest('.static-list-container') ||
                            document.querySelector(`input[placeholder*="${listId.replace(/_/g, ' ')}"]`)?.closest('.static-list-container');
            
            if (container) {
                const staticList = container.querySelector('.static-list');
                
                customItems[listId].forEach(itemText => {
                    // Check if item already exists
                    const existingItem = staticList.querySelector(`[data-value="${itemText.toLowerCase().replace(/\s+/g, '-')}"]`);
                    if (!existingItem) {
                        const newItem = document.createElement('div');
                        newItem.className = 'list-item custom-item';
                        newItem.setAttribute('data-value', itemText.toLowerCase().replace(/\s+/g, '-'));
                        newItem.setAttribute('data-custom', 'true');
                        
                        newItem.innerHTML = `
                            <span class="item-text">${itemText}</span>
                            <div class="item-actions">
                                <button class="btn btn-sm btn-warning edit-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                        
                        staticList.appendChild(newItem);
                    }
                });
            }
        });
        
        // Apply edited items to existing elements
        Object.keys(editedItems).forEach(listId => {
            const container = document.querySelector(`#${listId}`)?.closest('.static-list-container') ||
                            document.querySelector(`input[placeholder*="${listId.replace(/_/g, ' ')}"]`)?.closest('.static-list-container');
            
            if (container) {
                const staticList = container.querySelector('.static-list');
                
                Object.keys(editedItems[listId]).forEach(originalText => {
                    const newText = editedItems[listId][originalText];
                    const items = staticList.querySelectorAll('.list-item .item-text');
                    
                    items.forEach(itemTextElement => {
                        if (itemTextElement.textContent.trim() === originalText) {
                            itemTextElement.textContent = newText;
                            const listItem = itemTextElement.closest('.list-item');
                            listItem.classList.add('edited-item');
                        }
                    });
                });
            }
        });
    }
    
    // Load custom items when page loads
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(loadCustomItems, 100); // Small delay to ensure DOM is ready
    });
}

// Add ripple animation and custom item styles
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
    
    .custom-item {
         border-left: 3px solid #28a745;
         background-color: #f8f9fa;
     }
     
     .custom-item .item-text {
         font-weight: 500;
         color: #155724;
     }
     
     .edited-item {
         border-left: 3px solid #ffc107;
         background-color: #fff3cd;
     }
     
     .edited-item .item-text {
         font-weight: 500;
         color: #856404;
     }
     
     /* Fixed height for all static lists */
     .static-list-container {
         height: 400px;
         display: flex;
         flex-direction: column;
     }
     
     .static-list {
         flex: 1;
         overflow-y: auto;
         max-height: calc(400px - 60px); /* Subtract footer height */
         padding-right: 5px;
     }
     
     .static-list::-webkit-scrollbar {
         width: 6px;
     }
     
     .static-list::-webkit-scrollbar-track {
         background: #f1f1f1;
         border-radius: 3px;
     }
     
     .static-list::-webkit-scrollbar-thumb {
         background: #c1c1c1;
         border-radius: 3px;
     }
     
     .static-list::-webkit-scrollbar-thumb:hover {
         background: #a8a8a8;
     }
     
     .add-item-section {
         margin-top: auto;
         padding-top: 10px;
         border-top: 1px solid #e9ecef;
         background-color: white;
         min-height: 50px;
     }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(20px);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection