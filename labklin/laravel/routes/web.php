<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IhsController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Icd10Controller;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\KesmasController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ConsentController;
use App\Http\Controllers\LabklinController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\AnamnesesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMergeController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\LabkesmasController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\NotificationSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function () {
    //DASHBOARD GENERAL

    // Route::get('/profile/{id}', [DashboardController::class, 'home']);

    Route::get('/home', [DashboardController::class, 'dashboard'])->name('home');
    Route::get('/dashboardlab', [DashboardController::class, 'dashboardlab'])->name('dashboardlab');
    Route::get('/dashboardkm', [DashboardController::class, 'dashboardkm'])->name('dashboardkm');
    // Route::view('/home', 'dashboard', ['menu' => 'dashboard', 'submenu' => 'general'])->name('home');
    //USERS
    Route::resource('users', UserController::class);
    //PROFILE
    Route::get('/profile/{id}', [UserController::class, 'profile']);
    //UPDATE PROFILE USER
    Route::put('/profile/update/{id}', [UserController::class, 'updateprofile'])->name('profile.update'); //AKSI UPDATE
    //DOCTORS
    Route::resource('doctors', DoctorController::class);
    //DOCTORS SCHEDULE
    Route::resource('doctor-schedules', DoctorScheduleController::class);
    //PATIENT
    Route::resource('patients', PatientController::class);
    //PROFILE
    Route::get('/profile/{id}', [UserController::class, 'profile']);
    //PATIENT DATATABLE
    Route::get('/data-patients', [PatientController::class, 'serverside'])->name('patients.serverside');
    Route::get('/data-patients/json', [PatientController::class, 'datatablejson']);
    Route::get('/data-patients/jsonvisit', [PatientController::class, 'datatablejsonvisit']);
    Route::post('/data-patients/delete/{id}', [PatientController::class, 'destroyserverside'])->name('patients.destroyserverside');
    //ICD10 DATATABLE
    Route::get('/data-icd', [Icd10Controller::class, 'index'])->name('icd.list');
    Route::get('/data-icd/jsonvisit', [Icd10Controller::class, 'icdjsonvisit']);
    Route::get('/data-icd/{id}', [Icd10Controller::class, 'geticd']);
    //LOINC DATATABLE
    Route::get('/data-loinc/jsonvisit', [LaboratoryController::class, 'loincjsonvisit']);
    Route::get('/data-loinc/loincanswers/{id}', [LaboratoryController::class, 'getLoincAnswer']);
    Route::get('/loinc', [LaboratoryController::class, 'loinc'])->name('loinc.list');




    //PROFILE CLINIC
    Route::resource('profileclinic', ProfileController::class);
    //LOCATIONS
    Route::resource('locations', LocationController::class);
    //LOCATIONS
    Route::resource('organizations', OrganizationController::class);
    //NOTIFICATION SETTING
    Route::get('/notification/setting', [NotificationSettingController::class, 'edit'])->name('notification.setting');
    Route::put('/notification/setting', [NotificationSettingController::class, 'update'])->name('notification.setting.update');
    Route::get('/notification/test', [NotificationSettingController::class, 'test'])->name('notification.setting.test');
    //CONSENTS
    Route::resource('consents', ConsentController::class);
    //VISITS
    Route::resource('visits', VisitController::class);
    Route::get('/visits/{id}/payment', [VisitController::class, 'payment'])->name('visits.payment');
    Route::get('/visits/{id}/delete', [VisitController::class, 'delete'])->name('visits.delete');
    Route::get('/visits/progress/{id}', [VisitController::class, 'progress'])->name('visits.progress');
    Route::get('/visits/{id}/anamneses', [VisitController::class, 'anamneses'])->name('visits.anamneses');
    Route::get('/visits/{id}/services', [VisitController::class, 'services'])->name('visits.services');
    Route::get('/visits/deleteservices/{id}', [VisitController::class, 'deleteservices'])->name('visits.deleteservices');
    Route::get('/visits/{id}/resume', [VisitController::class, 'resume'])->name('visits.resume');
    Route::put('/updatefinish/{id}', [VisitController::class, 'updatefinish'])->name('visits.updatefinish');
    Route::post('/resendencounter/{id}', [VisitController::class, 'resendencounter'])->name('visits.resendencounter');
    //Menambahkan Update Service Update Detail
    Route::put('/visits/{id}/services/detail', [VisitController::class, 'serviceupdate'])->name('visits.serviceupdate');
    //UPDATE PAYMENT
    Route::put('/visits/updatepayment/{id}', [VisitController::class, 'updatepayment'])->name('visits.updatepayment');
    //PRINT RECEIPT INVOICE
    // Route::put('/visits/printreceipt/{id}', [VisitController::class, 'printreceipt'])->name('visits.printreceipt');
    //ANAMNESES
    Route::post('/anamneses/store', [AnamnesesController::class, 'store'])->name('anamneses.store');
    //LABORATORIES
    Route::resource('laboratory', LaboratoryController::class);
    //GET DATA LABORATORIES WHERE TEST_CODE
    Route::get('getLab/{id}', function ($id) {
        $labdetail = App\Models\Laboratory::where('test_code', $id)->get();
        return response()->json($labdetail);
    });

    // KODEWILAYAH LARAVOLT
    Route::get('getKota/{id}', function ($id) {
        $course = App\Models\CityModel::where('province_code', $id)->get();
        return response()->json($course);
    });
    Route::get('getKec/{id}', function ($id) {
        $course2 = App\Models\DistrictModel::where('city_code', $id)->get();
        return response()->json($course2);
    });
    Route::get('getKel/{id}', function ($id) {
        $course3 = App\Models\VillageModel::where('district_code', $id)->get();
        return response()->json($course3);
    });
    Route::get('getKode/{id}', function ($id) {
        $course4 = App\Models\VillageModel::where('code', $id)->get();
        return response()->json($course4);
    });
    Route::get('getnamakota/{id}', function ($id) {
        $course5 = App\Models\CityModel::where('code', $id)->get();
        return response()->json($course5);
    });
    Route::get('getlocation/{id}', function ($id) {
        $course6 = App\Models\Locations::where('location_uuid', $id)->get();
        return response()->json($course6);
    });
    Route::get('getdoctor/{id}', function ($id) {
        $course7 = App\Models\Doctor::where('doctor_id', $id)->get();
        return response()->json($course7);
    });

    // SATUSEHAT
    //GET PATIENT IHS
    Route::get('/getbynik/{id}', [IhsController::class, 'getbynik']);
    // GET DOCTOR IHS
    Route::get('/doctorbynik/{id}', [IhsController::class, 'getdoctorbynik']);
    Route::get('/getorganization/{id}', [IhsController::class, 'getorganization']);
    // CREATE LOCATION IHS
    Route::post('/location', [IhsController::class, 'location'])->name('location');

    // EXCEL IMPORT EXPORT
    Route::get('/import-loinc', [ExcelImportController::class, 'indexloinc'])->name('loinc');
    Route::post('/in-loinc', [ExcelImportController::class, 'importloinc'])->name('import.loinc');
    Route::post('/in-loincanswer', [ExcelImportController::class, 'importloincanswer'])->name('import.loincanswer');
    Route::post('/in-labtest', [ExcelImportController::class, 'importlabtest'])->name('import.labtest');
    Route::post('/in-parameter', [ExcelImportController::class, 'importparameter'])->name('import.parameter');
    Route::get('/ex-loinc', [ExcelExportController::class, 'exportloinc'])->name('export.loinc');
    Route::get('/ex-answerloinc', [ExcelExportController::class, 'exportanswerloinc'])->name('export.answerloinc');
    Route::get('/ex-labtest', [ExcelExportController::class, 'exportlabtest'])->name('export.labtest');
    Route::get('/ex-parameter', [ExcelExportController::class, 'exportparameter'])->name('export.parameter');


    // FPDF
    Route::get('/pdf', [PdfController::class, 'index']);
    Route::get('/print/receipt/{id}', [PdfController::class, 'receipt'])->name('print.receipt');
    Route::get('/print/receiptkm/{id}', [PdfController::class, 'receiptkm'])->name('print.receiptkm');
    Route::get('/print/receiptpks/{id}', [PdfController::class, 'receiptpks'])->name('print.receiptpks');
    Route::get('/print/labreport/{id}', [PdfController::class, 'labreport'])->name('print.labreport');
    Route::get('/print/record/{id}', [PdfController::class, 'record'])->name('print.record');
    Route::get('/print/label/{id}', [PdfController::class, 'label'])->name('print.label');
    Route::get('/print/labelkm/{id}', [PdfController::class, 'labelkm'])->name('print.labelkm');
    Route::get('/print/consent/{id}', [PdfController::class, 'consent'])->name('print.consent');
    //LAB MENU
    Route::resource('lab', LabController::class);
    //SERVICE
    Route::get('/data-lab/loadservice/{id}', [LabController::class, 'loadservice']);
    //LAB COLLECTION
    Route::get('collection', [LabController::class, 'collection'])->name('collection');
    Route::put('/lab/updatesampling/{id}', [LabController::class, 'updatesampling'])->name('lab.updatesampling');
    // Route::put('/lab/makeservicerequest/{id}', [LabController::class, 'makeservicerequest'])->name('lab.makeservicerequest');
    Route::put('/lab/makeservicerequest/{id}', [LabController::class, 'makeservicerequest'])->name('lab.makeservicerequest');
    Route::put('/lab/makespecimen/{id}', [LabController::class, 'makespecimen'])->name('lab.makespecimen');
    Route::put('/lab/makefullreport/{id}', [LabController::class, 'makefullreport'])->name('lab.makefullreport');
    Route::put('/lab/makereport/{id}', [LabController::class, 'makereport'])->name('lab.makereport');
    Route::put('/lab/makeobservation/{id}', [LabController::class, 'makeobservation'])->name('lab.makeobservation');
    Route::put('/lab/makeobservationsubpanel/{id}', [LabController::class, 'makeobservationsubpanel'])->name('lab.makeobservationsubpanel');
    Route::get('/lab/sendreport/{id}', [LabController::class, 'notifResult'])->name('lab.notifresult');
    Route::post('testing', [LabController::class, 'testing'])->name('testing');
    //UPDATE LAB SAMPLE
    Route::get('/collection/specimen/{id}', [LabController::class, 'specimen'])->name('specimen');
    //LAB RECEIVE
    Route::get('receive', [LabController::class, 'receive'])->name('receive');
    Route::put('/lab/updatereceive/{id}', [LabController::class, 'updatereceive'])->name('lab.updatereceive');
    Route::put('/lab/rejectreceive/{id}', [LabController::class, 'rejectreceive'])->name('lab.rejectreceive');
    //LAB RESULT
    Route::get('result', [LabController::class, 'result'])->name('result');
    Route::get('/lab/result/{id}', [LabController::class, 'resultentry'])->name('lab.result');
    Route::put('/entryresult', [LabController::class, 'entryresult'])->name('lab.entryresult');
    Route::post('/getAnswerId', [LabController::class, 'getAnswerId']);
    // Route::put('/entryresult', [LabklinController::class, 'entryresult'])->name('lab.entryresult');
    Route::put('/sendrequest', [LabController::class, 'sendrequest'])->name('lab.sendrequest');
    Route::put('/updateresult/{id}', [LabController::class, 'updateresult'])->name('lab.updateresult');
    Route::post('/lab/generate/{id}', [LabController::class, 'generate'])->name('lab.generate');
    //VALIDATION
    Route::get('validation', [LabController::class, 'validation'])->name('validation');
    Route::get('/lab/validation/{id}', [LabController::class, 'viewvalidation'])->name('lab.viewvalidation');
    Route::put('/updateval/{id}', [LabController::class, 'updateval'])->name('lab.updateval');
    Route::put('/updatetocollect/{id}', [LabController::class, 'updatetocollect'])->name('lab.updatetocollect');
    Route::put('/updatetoreceive/{id}', [LabController::class, 'updatetoreceive'])->name('lab.updatetoreceive');
    //REPORT
    Route::get('reportlab', [LabController::class, 'report'])->name('lab.report');
    Route::get('/printlab/{id}', [LabController::class, 'print'])->name('lab.print');
    //GENERATOR
    Route::get('/generator/mcu', [GeneratorController::class, 'mcu'])->name('all.mcu');
    Route::get('/generator/mcu/create', [GeneratorController::class, 'mcucreate'])->name('create.mcu');
    Route::get('/generator/mcu/{id}', [GeneratorController::class, 'genmcu'])->name('gen.mcu');
    Route::get('/generator/napza', [GeneratorController::class, 'napza'])->name('all.napza');
    Route::post('/generator/napza/create', [GeneratorController::class, 'napzacreate'])->name('create.napza');
    Route::get('/generator/napza/{id}', [GeneratorController::class, 'gennapza'])->name('gen.napza');
    Route::get('/generator/golda', [GeneratorController::class, 'golda'])->name('all.golda');
    Route::get('/generator/golda/create', [GeneratorController::class, 'goldacreate'])->name('create.golda');
    Route::get('/generator/golda/{id}', [GeneratorController::class, 'gengolda'])->name('gen.golda');
    Route::get('/generator/{id}/napza', [GeneratorController::class, 'resumenapza'])->name('generator.napza');

    //DATA MANAGEMENT REPORT
    Route::get('report/visit', [ReportController::class, 'reportvisit'])->name('report.visit');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.export.pdf');
    Route::get('report/revenue', [ReportController::class, 'reportrevenue'])->name('report.revenue');
    Route::get('/reports/export/excelrevenue', [ReportController::class, 'exportExcelRevenue'])->name('reports.export.excelrevenue');
    Route::get('/reports/export/pdfrevenue', [ReportController::class, 'exportPDFRevenue'])->name('reports.export.pdfrevenue');
    Route::get('report/laboratory', [ReportController::class, 'reportlaboratory'])->name('report.laboratory');
    Route::get('/reports/export/excellab', [ReportController::class, 'exportExcelLab'])->name('reports.export.excellab');
    Route::get('/reports/export/pdflab', [ReportController::class, 'exportPDFLab'])->name('reports.export.pdflab');
    Route::get('report/laboratory/detail', [ReportController::class, 'reportlaboratorydetail'])->name('report.laboratory.detail');
    Route::get('/reports/export/exceldetail', [ReportController::class, 'exportExcelLabDetail'])->name('reports.export.exceldetail');
    Route::get('/reports/export/pdfdetail', [ReportController::class, 'exportPDFLabDetail'])->name('reports.export.pdfdetail');
    //ON DEV
    Route::get('report/personel', [ReportController::class, 'reportpersonel'])->name('report.personel');
    Route::get('/reports/export/excelpersonel', [ReportController::class, 'exportExcelPersonel'])->name('reports.export.excelpersonel');
    Route::get('/reports/export/pdfpersonel', [ReportController::class, 'exportPDFPersonel'])->name('reports.export.pdfpersonel');

    //COMMAND ROUTE
    Route::get('optimize', function () {
        // Call and Artisan command from within your application.
        Artisan::call('optimize');
    })->name('optimize');

    Route::get('config', function () {
        // Call and Artisan command from within your application.
        Artisan::call('config:clear');
    })->name('config');

    //MERGE DATABASE LOCAL KE HOSTING DAN SEBALIKNYA
    Route::get('/merge-data', [DataMergeController::class, 'mergeData'])->name('merge.data');
    Route::get('/syncup', [DataMergeController::class, 'syncup'])->name('merge.syncup');
    Route::get('/merge-back', [DataMergeController::class, 'mergeBack'])->name('merge.back');
    Route::get('/syncdown', [DataMergeController::class, 'syncdown'])->name('merge.syncdown');
    //BACKUP
    Route::get('/backupmanager', [BackupController::class, 'backupmanager'])->name('backup.manager');
    Route::get('/backup-db', [BackupController::class, 'backupDatabase'])->name('backup.run');

    //KESMAS
    Route::resource('parameter', ParameterController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('/customers/get-detail/{id}', [CustomerController::class, 'getDetail'])->name('customers.getdetail');
    Route::resource('kesmas', KesmasController::class);
    Route::get('/kesmas/sample/{id}', [KesmasController::class, 'sample'])->name('kesmas.sample');
    Route::get('/kesmas/parameter/{id}', [KesmasController::class, 'parameter'])->name('kesmas.parameter');
    Route::get('/kesmas/get-sampler/{id}', [KesmasController::class, 'getSampler'])->name('kesmas.getsampler');
    Route::post('/kesmas/save-parameters', [KesmasController::class, 'saveParameters'])->name('kesmas.saveparameters');
    Route::get('/kesmas/get-parameters/{id}', [KesmasController::class, 'getParameters'])->name('kesmas.getparameters');
    Route::post('/kesmas/save-samples', [KesmasController::class, 'saveSamples'])->name('kesmas.savesamples');
    Route::get('/kesmas/check-code/{id}', [KesmasController::class, 'checkCode'])->name('kesmas.checkcode');
    Route::post('/kesmas/create-fpps/{id}', [KesmasController::class, 'createfpps'])->name('kesmas.createfpps');
    Route::get('/kesmas/review/{id}', [KesmasController::class, 'review'])->name('kesmas.review');
    Route::post('/kesmas/savereview/{id}', [KesmasController::class, 'savereview'])->name('kesmas.savereview');
    Route::get('/kesmas/reject/{id}', [KesmasController::class, 'reject'])->name('kesmas.reject');
    Route::get('/kesmas/fpps/{id}', [KesmasController::class, 'fpps'])->name('kesmas.fpps');
    Route::get('/kesmas/print/{id}', [KesmasController::class, 'print'])->name('kesmas.print');
    Route::get('/kesmas/printkan/{id}', [KesmasController::class, 'printkan'])->name('kesmas.printkan');
    Route::get('/kesmas/sendorder/{id}', [KesmasController::class, 'sendOrder'])->name('kesmas.sendorder');

    //PAYMENT
    Route::get('/payment/kesmas', [PaymentController::class, 'kesmas'])->name('payment.kesmas');
    Route::get('/payment/kesmas/input/{id}', [PaymentController::class, 'inputkm'])->name('payment.inputkm');
    Route::get('/payment/kesmas/inputpks/{id}', [PaymentController::class, 'inputpks'])->name('payment.inputpks');
    Route::get('/payment/kesmas/pay/{id}', [PaymentController::class, 'paykm'])->name('payment.paykm');
    Route::get('/payment/kesmas/paypks/{id}', [PaymentController::class, 'paypks'])->name('payment.paypks');
    Route::get('/payment/clinic', [PaymentController::class, 'clinic'])->name('payment.clinic');
    Route::get('/payment/clinic/input/{id}', [PaymentController::class, 'inputcl'])->name('payment.inputcl');
    Route::get('/payment/clinic/pay/{id}', [PaymentController::class, 'paycl'])->name('payment.paycl');

    //LABKESMAS
    Route::get('/labkesmas', [LabkesmasController::class, 'labkesmas'])->name('labkesmas');
    Route::get('/labkesmas/status', [LabkesmasController::class, 'status'])->name('labkesmas.status');
    Route::get('/labkesmas/receive', [LabkesmasController::class, 'receive'])->name('labkesmas.receive');
    Route::get('/labkesmas/updatereceive/{id}', [LabkesmasController::class, 'updatereceive'])->name('labkesmas.updatereceive');
    Route::get('/labkesmas/entry', [LabkesmasController::class, 'entry'])->name('labkesmas.entry');
    Route::get('/labkesmas/entryresult/{id}', [LabkesmasController::class, 'entryresult'])->name('labkesmas.entryresult');
    Route::put('/labkesmas/saveresult/{id}', [LabkesmasController::class, 'saveresult'])->name('labkesmas.saveresult');
    Route::put('/labkesmas/savereference/{id}', [LabkesmasController::class, 'savereference'])->name('labkesmas.savereference');
    Route::put('/labkesmas/saveunit/{id}', [LabkesmasController::class, 'saveunit'])->name('labkesmas.saveunit');
    Route::put('/labkesmas/savemethod/{id}', [LabkesmasController::class, 'savemethod'])->name('labkesmas.savemethod');
    Route::put('/labkesmas/saveprocess/{id}', [LabkesmasController::class, 'saveprocess'])->name('labkesmas.saveprocess');
    Route::get('/labkesmas/verify', [LabkesmasController::class, 'verify'])->name('labkesmas.verify');
    Route::get('/labkesmas/verification/{id}', [LabkesmasController::class, 'verification'])->name('labkesmas.verification');
    Route::put('/labkesmas/updateverify/{id}', [LabkesmasController::class, 'updateverify'])->name('labkesmas.updateverify');
    Route::put('/labkesmas/rerun/{id}', [LabkesmasController::class, 'rerun'])->name('labkesmas.rerun');
    Route::get('/labkesmas/validity', [LabkesmasController::class, 'validity'])->name('labkesmas.validity');
    Route::get('/labkesmas/validation/{id}', [LabkesmasController::class, 'validation'])->name('labkesmas.validation');
    Route::get('/labkesmas/draft/{id}', [LabkesmasController::class, 'draft'])->name('labkesmas.draft');
    Route::get('/labkesmas/draftverify/{id}', [LabkesmasController::class, 'draftverify'])->name('labkesmas.draftverify');
    Route::put('/labkesmas/updatevalidate/{id}', [LabkesmasController::class, 'updatevalidate'])->name('labkesmas.updatevalidate');
    Route::put('/labkesmas/cancel/{id}', [LabkesmasController::class, 'cancel'])->name('labkesmas.cancel');
    Route::get('/labkesmas/report', [LabkesmasController::class, 'report'])->name('labkesmas.report');
});

//NOT AUTHENTICATED
Route::get('/progress', [ProgressController::class, 'development'])->name('development');
Route::get('/verify/labreport/{id}', [PdfController::class, 'verifylabreport'])->name('verify.labreport');
Route::get('/verify-napza/sk/{id}', [PdfController::class, 'verifynafza'])->name('verify.nafza');
Route::get('/verify-km/lhu/{id}', [PdfController::class, 'verifylhu'])->name('verify-km.lhu');
Route::get('/verify-km/lhukan/{id}', [PdfController::class, 'verifylhukan'])->name('verify-km.lhukan');
Route::get('/fonnte/{id}', [ProgressController::class, 'testfonnte'])->name('testfonnte');