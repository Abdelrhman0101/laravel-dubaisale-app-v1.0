@extends('layouts.dashboard')

@section('title', 'البحث والفلتر - Search & Filter')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary mb-1">البحث والفلتر</h2>
                    <p class="text-muted mb-0">Search & Filter Management</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">البحث والفلتر</li>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Car Sale Tab Content -->
    <div class="tab-content-wrapper">
        <div class="tab-content active" id="car-sale-content">
            <div class="row">
                <div class="col-12">
                    <div class="car-filter-card">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="fas fa-car me-2"></i>
                                بيع السيارات - Car Sale Filter
                            </h4>
                        </div>
                        <div class="card-body">
                            <!-- Make Section -->
                            <div class="filter-section mb-4">
                                <div class="section-header">
                                    <h5 class="section-title">
                                        <i class="fas fa-industry me-2"></i>
                                        الماركة - Make
                                    </h5>
                                    <button class="btn btn-primary btn-sm add-make-btn">
                                        <i class="fas fa-plus me-1"></i>
                                        إضافة ماركة
                                    </button>
                                </div>
                                <div class="makes-container" id="makes-container">
                                    <!-- Makes will be dynamically added here -->
                                </div>
                            </div>

                            <!-- Year Section -->
                            <div class="filter-section mb-4">
                                <div class="section-header">
                                    <h5 class="section-title">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        السنة - Year
                                    </h5>
                                </div>
                                <div class="static-list-container">
                                    <div class="static-list" id="years-container">
                                        <!-- Years will be dynamically added here -->
                                    </div>
                                    <div class="add-item-section fixed-footer">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="إضافة سنة جديدة" id="new-year-input">
                                            <button class="btn btn-success add-item-btn add-year-btn" type="button">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="preview-section">
                                <h5 class="section-title">
                                    <i class="fas fa-eye me-2"></i>
                                    معاينة البيانات - Data Preview
                                </h5>
                                <div class="preview-container" id="preview-container">
                                    <div class="empty-state">
                                        <i class="fas fa-info-circle"></i>
                                        <p>قم بإضافة الماركات والموديلات لرؤية المعاينة</p>
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

<!-- Add Make Modal -->
<div class="modal fade" id="addMakeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    إضافة ماركة جديدة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addMakeForm">
                    
                    <div class="mb-3">
                        <label for="makeNameEn" class="form-label">اسم الماركة بالإنجليزية</label>
                        <input type="text" class="form-control" id="makeNameEn" placeholder="Example: Toyota, BMW, Mercedes" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveMakeBtn">
                    <i class="fas fa-save me-1"></i>
                    حفظ الماركة
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Model Modal -->
<div class="modal fade" id="addModelModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    إضافة موديل جديد
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addModelForm">
                    <div class="mb-3">
                        <label class="form-label">الماركة المحددة</label>
                        <input type="text" class="form-control" id="selectedMake" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modelNameEn" class="form-label">اسم الموديل بالإنجليزية</label>
                        <input type="text" class="form-control" id="modelNameEn" placeholder="Example: Camry, Corolla, Prius" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveModelBtn">
                    <i class="fas fa-save me-1"></i>
                    حفظ الموديل
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Trim Modal -->
<div class="modal fade" id="addTrimModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    إضافة تريم جديد
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addTrimForm">
                    <div class="mb-3">
                        <label class="form-label">الماركة والموديل</label>
                        <input type="text" class="form-control" id="selectedMakeModel" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="trimNameEn" class="form-label">اسم التريم بالإنجليزية</label>
                        <input type="text" class="form-control" id="trimNameEn" placeholder="Example: LE, XLE, Limited" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveTrimBtn">
                    <i class="fas fa-save me-1"></i>
                    حفظ التريم
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Year Modal -->
<div class="modal fade" id="addYearModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    إضافة سنة جديدة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addYearForm">
                    <div class="mb-3">
                        <label for="yearValue" class="form-label">السنة</label>
                        <input type="number" class="form-control" id="yearValue" placeholder="مثال: 2024, 2023, 2022" min="1900" max="2030" required>
                    </div>
                    <div class="mb-3">
                        <label for="yearDescription" class="form-label">وصف السنة (اختياري)</label>
                        <input type="text" class="form-control" id="yearDescription" placeholder="مثال: موديل حديث، كلاسيكي">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveYearBtn">
                    <i class="fas fa-save me-1"></i>
                    حفظ السنة
                </button>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-blue: #3490dc;
    --secondary-blue: #2563eb;
    --light-blue: #dbeafe;
    --dark-blue: #1e40af;
    --gradient-blue: linear-gradient(135deg, #3490dc 0%, #2563eb 100%);
    --shadow-blue: 0 4px 15px rgba(52, 144, 220, 0.2);
    --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Tabs Styling */
.tabs-container {
    background: var(--gradient-blue);
    border-radius: 20px;
    padding: 8px;
    box-shadow: var(--shadow-lg);
    margin-bottom: 2rem;
}

.tabs-wrapper {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding: 4px;
}

.tab-btn {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    padding: 12px 20px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 140px;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.tab-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.tab-btn.active {
    background: white;
    color: var(--primary-blue);
    font-weight: 600;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.tab-text {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
}

.tab-text .en {
    font-size: 0.9rem;
    font-weight: 500;
}

.tab-text .ar {
    font-size: 0.75rem;
    opacity: 0.8;
}

/* Car Filter Card */
.car-filter-card {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    border: none;
    overflow: hidden;
}

.car-filter-card .card-header {
    background: var(--gradient-blue);
    color: white;
    padding: 20px 30px;
    border: none;
    border-radius: 0;
}

.car-filter-card .card-body {
    padding: 30px;
}

/* Filter Section */
.filter-section {
    background: #f8fafc;
    border-radius: 16px;
    padding: 25px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.filter-section:hover {
    border-color: var(--primary-blue);
    box-shadow: var(--shadow-blue);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-title {
    color: var(--dark-blue);
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
}

.add-make-btn {
    background: var(--gradient-blue);
    border: none;
    border-radius: 10px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-blue);
}

.add-make-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 144, 220, 0.3);
}

/* Makes Container */
.makes-container {
    display: grid;
    gap: 20px;
}

.make-item {
    background: white;
    border-radius: 16px;
    padding: 20px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.make-item:hover {
    border-color: var(--primary-blue);
    box-shadow: var(--shadow-blue);
    transform: translateY(-2px);
}

.make-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f5f9;
}

.make-title {
    font-weight: 600;
    color: var(--dark-blue);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.make-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-action {
    padding: 8px 16px;
    border-radius: 10px;
    border: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.btn-add-model {
    background: var(--gradient-blue);
    color: white;
}

.btn-add-model:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-blue);
}

.btn-delete-make {
    background: #ef4444;
    color: white;
}

.btn-delete-make:hover {
    background: #dc2626;
    transform: translateY(-1px);
}

/* Models Grid */
.models-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.model-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 15px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.model-item:hover {
    background: var(--light-blue);
    border-color: var(--primary-blue);
    transform: translateY(-1px);
}

.model-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.model-name {
    font-weight: 500;
    color: var(--dark-blue);
    margin: 0;
}

.model-actions {
    display: flex;
    gap: 5px;
}

.btn-sm-action {
    padding: 6px 10px;
    border-radius: 8px;
    border: none;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 4px;
    font-weight: 500;
}

.btn-add-trim {
    background: var(--primary-blue);
    color: white;
}

.btn-delete-model {
    background: #ef4444;
    color: white;
}

/* Trims List */
.trims-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}

.trim-badge {
    background: var(--gradient-blue);
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
}

.trim-badge:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-blue);
}

.trim-delete {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.trim-delete:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Static List Container for Years */
.static-list-container {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: white;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    position: relative;
}

.static-list {
    padding: 0;
    margin: 0;
    min-height: 200px;
}

.year-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    background: white;
}

.year-item:last-child {
    border-bottom: none;
}

.year-item:hover {
    background-color: #f8fafc;
    transform: translateX(2px);
    border-left: 4px solid var(--primary-blue);
}

.year-content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.year-value {
    font-weight: 600;
    color: var(--dark-blue);
    margin: 0;
    font-size: 1rem;
}

.year-description {
    font-size: 0.8rem;
    color: #64748b;
    margin: 2px 0 0 0;
}

.year-delete {
    background: #ef4444;
    border: none;
    color: white;
    border-radius: 6px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0;
}

.year-item:hover .year-delete {
    opacity: 1;
}

.year-delete:hover {
    background: #dc2626;
    transform: scale(1.1);
}

.years-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 150px;
    color: #94a3b8;
    text-align: center;
    padding: 20px;
}

.years-empty-state i {
    font-size: 2.5rem;
    margin-bottom: 12px;
    opacity: 0.5;
}

.years-empty-state p {
    margin: 0;
    font-size: 0.95rem;
}

.add-item-section.fixed-footer {
    position: sticky;
    bottom: 0;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-top: 2px solid var(--primary-blue);
    box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
    z-index: 10;
    padding: 12px;
}

.add-item-btn {
    border-radius: 0 8px 8px 0;
    transition: all 0.3s ease;
    font-weight: 600;
}

.add-item-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.add-year-btn {
    background: var(--gradient-blue);
    border: none;
    border-radius: 10px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-blue);
}

.add-year-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 144, 220, 0.3);
}

/* Preview Section */
.preview-section {
    background: #f8fafc;
    border-radius: 16px;
    padding: 25px;
    border: 2px solid #e2e8f0;
}

.preview-container {
    background: white;
    border-radius: 12px;
    padding: 20px;
    min-height: 200px;
    border: 1px solid #e2e8f0;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 160px;
    color: #64748b;
    text-align: center;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 15px;
    opacity: 0.5;
}

/* Modal Styling */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: var(--shadow-lg);
}

.modal-header {
    background: var(--gradient-blue);
    color: white;
    border-radius: 16px 16px 0 0;
    border: none;
}

.modal-title {
    font-weight: 600;
}

.btn-close {
    filter: invert(1);
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 12px 16px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-blue);
    box-shadow: var(--shadow-blue);
}

/* Responsive Design */
@media (max-width: 768px) {
    .section-header {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .models-grid {
        grid-template-columns: 1fr;
    }
    
    .tabs-wrapper {
        flex-direction: column;
    }
    
    .tab-btn {
        min-width: auto;
    }
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.slide-in {
    animation: slideIn 0.3s ease-out;
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
</style>

<script>
// Global variables
let carData = {
    makes: [],
    years: []
};
let currentMakeId = null;
let currentModelId = null;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
    loadSampleData();
    updatePreview();
});

// Initialize event listeners
function initializeEventListeners() {
    // Add Make button
    document.querySelector('.add-make-btn').addEventListener('click', function() {
        showAddMakeModal();
    });
    
    // Add Year button (from input field)
    document.querySelector('.add-year-btn').addEventListener('click', function() {
        const input = document.getElementById('new-year-input');
        const yearValue = input.value.trim();
        
        if (yearValue) {
            // Validate year
            const year = parseInt(yearValue);
            if (isNaN(year) || year < 1900 || year > 2030) {
                alert('يرجى إدخال سنة صحيحة بين 1900 و 2030');
                return;
            }
            
            // Check for duplicates
            if (carData.years.some(y => y.value === year)) {
                alert('هذه السنة موجودة بالفعل');
                return;
            }
            
            // Add year
            const newYear = {
                id: Date.now(),
                value: year,
                description: ''
            };
            
            carData.years.push(newYear);
            carData.years.sort((a, b) => b.value - a.value); // Sort descending
            
            renderYears();
            input.value = '';
        }
    });
    
    // Enter key support for year input
    document.getElementById('new-year-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.querySelector('.add-year-btn').click();
        }
    });
    
    // Save Make button
    document.getElementById('saveMakeBtn').addEventListener('click', function() {
        saveMake();
    });
    
    // Save Model button
    document.getElementById('saveModelBtn').addEventListener('click', function() {
        saveModel();
    });
    
    // Save Trim button
    document.getElementById('saveTrimBtn').addEventListener('click', function() {
        saveTrim();
    });
    
    // Save Year button
    document.getElementById('saveYearBtn').addEventListener('click', function() {
        saveYear();
    });
    
    // Modal reset on close
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function() {
            resetModalForms();
        });
    });
}

// Load sample data
function loadSampleData() {
    carData.makes = [
        {
            id: 1,
            name: 'تويوتا',
            nameEn: 'Toyota',
            models: [
                {
                    id: 1,
                    name: 'كامري',
                    nameEn: 'Camry',
                    trims: [
                        { id: 1, name: 'LE', nameEn: 'LE' },
                        { id: 2, name: 'XLE', nameEn: 'XLE' }
                    ]
                },
                {
                    id: 2,
                    name: 'كورولا',
                    nameEn: 'Corolla',
                    trims: [
                        { id: 3, name: 'L', nameEn: 'L' },
                        { id: 4, name: 'LE', nameEn: 'LE' }
                    ]
                }
            ]
        }
    ];
    
    carData.years = [
        { id: 1, value: 2024, description: 'موديل حديث' },
        { id: 2, value: 2023, description: 'موديل العام الماضي' },
        { id: 3, value: 2022, description: '' }
    ];
    
    renderMakes();
    renderYears();
}

// Show Add Make Modal
function showAddMakeModal() {
    const modal = new bootstrap.Modal(document.getElementById('addMakeModal'));
    modal.show();
}

// Show Add Model Modal
function showAddModelModal(makeId) {
    currentMakeId = makeId;
    const make = carData.makes.find(m => m.id === makeId);
    document.getElementById('selectedMake').value = `${make.name} - ${make.nameEn}`;
    
    const modal = new bootstrap.Modal(document.getElementById('addModelModal'));
    modal.show();
}

// Show Add Trim Modal
function showAddTrimModal(makeId, modelId) {
    currentMakeId = makeId;
    currentModelId = modelId;
    
    const make = carData.makes.find(m => m.id === makeId);
    const model = make.models.find(m => m.id === modelId);
    
    document.getElementById('selectedMakeModel').value = `${make.name} - ${model.name}`;
    
    const modal = new bootstrap.Modal(document.getElementById('addTrimModal'));
    modal.show();
}

// Show Add Year Modal
function showAddYearModal() {
    const modal = new bootstrap.Modal(document.getElementById('addYearModal'));
    modal.show();
}

// Save Make
function saveMake() {
    const name = document.getElementById('makeName').value.trim();
    const nameEn = document.getElementById('makeNameEn').value.trim();
    
    if (!name || !nameEn) {
        alert('يرجى ملء جميع الحقول');
        return;
    }
    
    const newMake = {
        id: Date.now(),
        name: name,
        nameEn: nameEn,
        models: []
    };
    
    carData.makes.push(newMake);
    renderMakes();
    updatePreview();
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('addMakeModal')).hide();
}

// Save Model
function saveModel() {
    const name = document.getElementById('modelName').value.trim();
    const nameEn = document.getElementById('modelNameEn').value.trim();
    
    if (!name || !nameEn) {
        alert('يرجى ملء جميع الحقول');
        return;
    }
    
    const make = carData.makes.find(m => m.id === currentMakeId);
    const newModel = {
        id: Date.now(),
        name: name,
        nameEn: nameEn,
        trims: []
    };
    
    make.models.push(newModel);
    renderMakes();
    updatePreview();
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('addModelModal')).hide();
}

// Save Trim
function saveTrim() {
    const name = document.getElementById('trimName').value.trim();
    const nameEn = document.getElementById('trimNameEn').value.trim();
    
    if (!name || !nameEn) {
        alert('يرجى ملء جميع الحقول');
        return;
    }
    
    const make = carData.makes.find(m => m.id === currentMakeId);
    const model = make.models.find(m => m.id === currentModelId);
    
    const newTrim = {
        id: Date.now(),
        name: name,
        nameEn: nameEn
    };
    
    model.trims.push(newTrim);
    renderMakes();
    updatePreview();
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('addTrimModal')).hide();
}

// Save Year
function saveYear() {
    const value = parseInt(document.getElementById('yearValue').value);
    const description = document.getElementById('yearDescription').value.trim();
    
    if (!value || value < 1900 || value > 2030) {
        alert('يرجى إدخال سنة صحيحة بين 1900 و 2030');
        return;
    }
    
    // Check if year already exists
    if (carData.years.find(y => y.value === value)) {
        alert('هذه السنة موجودة بالفعل');
        return;
    }
    
    const newYear = {
        id: Date.now(),
        value: value,
        description: description
    };
    
    carData.years.push(newYear);
    
    // Sort years in descending order
    carData.years.sort((a, b) => b.value - a.value);
    
    renderYears();
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('addYearModal')).hide();
}

// Delete Make
function deleteMake(makeId) {
    if (confirm('هل أنت متأكد من حذف هذه الماركة وجميع موديلاتها؟')) {
        carData.makes = carData.makes.filter(m => m.id !== makeId);
        renderMakes();
        updatePreview();
    }
}

// Delete Model
function deleteModel(makeId, modelId) {
    if (confirm('هل أنت متأكد من حذف هذا الموديل وجميع تريماته؟')) {
        const make = carData.makes.find(m => m.id === makeId);
        make.models = make.models.filter(m => m.id !== modelId);
        renderMakes();
        updatePreview();
    }
}

// Delete Trim
function deleteTrim(makeId, modelId, trimId) {
    if (confirm('هل أنت متأكد من حذف هذا التريم؟')) {
        const make = carData.makes.find(m => m.id === makeId);
        const model = make.models.find(m => m.id === modelId);
        model.trims = model.trims.filter(t => t.id !== trimId);
        
        renderMakes();
        updatePreview();
    }
}

// Delete Year
function deleteYear(yearId) {
    if (confirm('هل أنت متأكد من حذف هذه السنة؟')) {
        carData.years = carData.years.filter(y => y.id !== yearId);
        renderYears();
    }
}

// Render Makes
function renderMakes() {
    const container = document.getElementById('makes-container');
    
    if (carData.makes.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-car"></i>
                <p>لا توجد ماركات مضافة بعد. قم بإضافة ماركة جديدة للبدء.</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = carData.makes.map(make => `
        <div class="make-item fade-in">
            <div class="make-header">
                <h6 class="make-title">
                    <i class="fas fa-industry"></i>
                    ${make.name} - ${make.nameEn}
                </h6>
                <div class="make-actions">
                    <button class="btn btn-action btn-add-model" onclick="showAddModelModal(${make.id})">
                        <i class="fas fa-plus"></i>
                        إضافة موديل
                    </button>
                    <button class="btn btn-action btn-delete-make" onclick="deleteMake(${make.id})">
                        <i class="fas fa-trash"></i>
                        حذف الماركة
                    </button>
                </div>
            </div>
            
            ${make.models.length > 0 ? `
                <div class="models-grid">
                    ${make.models.map(model => `
                        <div class="model-item slide-in">
                            <div class="model-header">
                                <h6 class="model-name">${model.name} - ${model.nameEn}</h6>
                                <div class="model-actions">
                            <button class="btn btn-sm-action btn-add-trim" onclick="showAddTrimModal(${make.id}, ${model.id})" title="إضافة تريم">
                                <i class="fas fa-plus"></i>
                                تريم
                            </button>
                            <button class="btn btn-sm-action btn-delete-model" onclick="deleteModel(${make.id}, ${model.id})" title="حذف الموديل">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                            </div>
                            
                            ${model.trims.length > 0 ? `
                                <div class="trims-list">
                                    ${model.trims.map(trim => `
                                        <span class="trim-badge">
                                            ${trim.name}
                                            <button class="trim-delete" onclick="deleteTrim(${make.id}, ${model.id}, ${trim.id})">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                                    `).join('')}
                                </div>
                            ` : '<p class="text-muted small mb-0">لا توجد تريمات مضافة</p>'}
                        </div>
                    `).join('')}
                </div>
            ` : '<p class="text-muted">لا توجد موديلات مضافة لهذه الماركة</p>'}
        </div>
    `).join('');
}

// Render Years
function renderYears() {
    const container = document.getElementById('years-container');
    
    if (carData.years.length === 0) {
        container.innerHTML = `
            <div class="years-empty-state">
                <i class="fas fa-calendar-alt"></i>
                <p>لم يتم إضافة أي سنوات بعد</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = carData.years.map(year => `
        <div class="year-item" data-year-id="${year.id}">
            <div class="year-content">
                <div class="year-value">${year.value}</div>
                ${year.description ? `<div class="year-description">${year.description}</div>` : ''}
            </div>
            <button class="year-delete" onclick="deleteYear(${year.id})" title="حذف السنة">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `).join('');
}

// Update Preview
function updatePreview() {
    const container = document.getElementById('preview-container');
    
    if (carData.makes.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-info-circle"></i>
                <p>قم بإضافة الماركات والموديلات لرؤية المعاينة</p>
            </div>
        `;
        return;
    }
    
    const totalMakes = carData.makes.length;
    const totalModels = carData.makes.reduce((sum, make) => sum + make.models.length, 0);
    const totalTrims = carData.makes.reduce((sum, make) => 
        sum + make.models.reduce((modelSum, model) => modelSum + model.trims.length, 0), 0
    );
    
    container.innerHTML = `
        <div class="preview-stats">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-industry text-primary"></i>
                        <h4 class="text-primary">${totalMakes}</h4>
                        <p class="mb-0">ماركة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-car text-success"></i>
                        <h4 class="text-success">${totalModels}</h4>
                        <p class="mb-0">موديل</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-cog text-info"></i>
                        <h4 class="text-info">${totalTrims}</h4>
                        <p class="mb-0">تريم</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="preview-data mt-4">
            <h6 class="mb-3">هيكل البيانات:</h6>
            <div class="data-structure">
                ${carData.makes.map(make => `
                    <div class="make-preview">
                        <strong>${make.name}</strong>
                        ${make.models.length > 0 ? `
                            <ul class="models-preview">
                                ${make.models.map(model => `
                                    <li>
                                        ${model.name}
                                        ${model.trims.length > 0 ? `
                                            <ul class="trims-preview">
                                                ${model.trims.map(trim => `<li>${trim.name}</li>`).join('')}
                                            </ul>
                                        ` : ''}
                                    </li>
                                `).join('')}
                            </ul>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        </div>
    `;
}

// Reset Modal Forms
function resetModalForms() {
    document.querySelectorAll('.modal form').forEach(form => {
        form.reset();
    });
    currentMakeId = null;
    currentModelId = null;
}
</script>

<style>
/* Additional Preview Styles */
.preview-stats .stat-card {
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.preview-stats .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-blue);
}

.preview-stats .stat-card i {
    font-size: 2rem;
    margin-bottom: 10px;
}

.preview-stats .stat-card h4 {
    font-weight: 700;
    margin: 10px 0 5px 0;
}

.data-structure {
    background: #f8fafc;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}

.make-preview {
    margin-bottom: 15px;
    color: var(--dark-blue);
}

.models-preview {
    margin: 8px 0 0 20px;
    color: #059669;
}

.trims-preview {
    margin: 5px 0 0 20px;
    color: #0891b2;
}

.models-preview li,
.trims-preview li {
    margin-bottom: 3px;
}
</style>
@endsection