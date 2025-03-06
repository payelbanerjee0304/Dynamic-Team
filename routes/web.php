<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Chiefadmin\ChiefadminController;
use App\Http\Controllers\Admin\importMemberController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\BirthdayAdminController;
use App\Http\Controllers\Admin\DesignationAdminController;
use App\Http\Controllers\Admin\TeamAdminController;
use App\Http\Controllers\Admin\EventAdminController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\NewsUserController;
use App\Http\Controllers\User\BirthdayUserController;
use App\Http\Controllers\User\TeamUserController;
use App\Http\Controllers\User\EventUserController;

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
   return view('welcome');
})->name('addMember');

Route::prefix('admin')->group(function () {
   Route::get('/login',[AdminController::class, 'login'])->name('admin.login')->middleware('admin.redirect');

   Route::post('/save', [AdminController::class, 'save'])->name('admin.save');
   Route::post('/verifyAndLogin', [AdminController::class, 'verifyAndLogin'])->name('admin.verifyAndLogin');
   Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

   Route::middleware(['adminLoggedIn'])->group(function () {

      Route::get('/member-view', [AdminController::class, 'allMembers'])->name('allMember');
      Route::get('/members_pagination', [AdminController::class, 'paginateMember'])->name('allMember.pagination');
      Route::get('/members_search', [AdminController::class, 'searchMember'])->name('allMember.search');
      
      Route::get('/members_searchKeyword', [AdminController::class, 'searchKeywordMember'])->name('allMember.searchKeyword');
      Route::get('/members/suggestions', [AdminController::class, 'suggestMembers'])->name('allMember.suggestions');
      Route::get('/members_filter', [AdminController::class, 'filterMember'])->name('allMember.filter');
      Route::get('/members_filterVerify', [AdminController::class, 'filterVerify'])->name('allMember.filterVerify');
      Route::get('/view', [AdminController::class, 'view'])->name('admin.view');

      Route::get('/add-member', [AdminController::class, 'addMember'])->name('admin.addMember');
      Route::post('/insert-member', [AdminController::class, 'insertMember'])->name('admin.insertMember');
      Route::get('/edit-member/{id}', [AdminController::class, 'editMember'])->name('admin.editMember');
      Route::post('/update-member', [AdminController::class, 'updateMember'])->name('admin.updateMember');
      Route::delete('/delete-member', [AdminController::class, 'deleteMember'])->name('admin.deleteMember');

      Route::get('/reverify-member/{id}', [AdminController::class, 'reverifyMember'])->name('admin.reverifyMember');

      Route::post('/send-sms', [AdminController::class, 'sendSms'])->name('admin.sendSms');
      Route::post('/sendAll-sms', [AdminController::class, 'sendAllSms'])->name('admin.sendAllSms');
      Route::get('/download-members', [AdminController::class, 'downloadMembers'])->name('members.download');

      Route::get('/import-members',[importMemberController::class, 'importMembersPage'])->name('admin.importMembersPage');
      Route::post('/import-members',[importMemberController::class, 'importMembersInsert'])->name('admin.importMembersInsert');

      Route::get('/create-news',[NewsAdminController::class, 'newsCreate'])->name('admin.newsCreate');
      Route::get('/testDummy',[NewsAdminController::class, 'testDummy'])->name('admin.testDummy');
      Route::post('/insert-news',[NewsAdminController::class, 'insertNews'])->name('admin.insertNews');
      Route::get('/all-news',[NewsAdminController::class, 'allNews'])->name('admin.allNews');
      Route::post('/delete-news', [NewsAdminController::class, 'deleteNews'])->name('admin.deleteNews');
      Route::get('/edit-news/{newsId}', [NewsAdminController::class, 'editNews'])->name('admin.editNews');
      Route::post('/update-news', [NewsAdminController::class, 'updateNews'])->name('admin.updateNews');
      Route::get('/news-details/{newsId}', [NewsAdminController::class, 'newsDetails'])->name('admin.newsDetails');

      Route::get('/see-all-birthdays', [BirthdayAdminController::class, 'seeAllBirthdays'])->name('admin.seeAllBirthdays');

      Route::get('/create-new-designation', [DesignationAdminController::class, 'createNewDesignation'])->name('admin.createNewDesignation');
      Route::post('/insert-new-designation',[DesignationAdminController::class, 'insertNewDesignation'])->name('admin.insertNewDesignation');
      Route::get('/all-designation', [DesignationAdminController::class, 'allDesignation'])->name('admin.allDesignation');
      Route::delete('/delete-designation', [DesignationAdminController::class, 'deleteDesignation'])->name('admin.deleteDesignation');
      Route::get('/edit-designation/{id}', [DesignationAdminController::class, 'editDesignation'])->name('admin.editDesignation');
      Route::post('/update-designation', [DesignationAdminController::class, 'updateDesignation'])->name('admin.updateDesignation');


      Route::get('/create-new-team', [TeamAdminController::class, 'createNewTeam'])->name('admin.createNewTeam');
      Route::post('/insert-new-team',[TeamAdminController::class, 'insertNewTeam'])->name('admin.insertNewTeam');
      Route::get('/edit-team-details/{id}', [TeamAdminController::class, 'editTeamDetails'])->name('admin.editTeamDetails');
      Route::post('/update-team-details',[TeamAdminController::class, 'updateTeamDetails'])->name('admin.updateTeamDetails');
      Route::delete('/delete-team', [TeamAdminController::class, 'deleteTeam'])->name('admin.deleteTeam');
      Route::get('/all-team',[TeamAdminController::class, 'allTeam'])->name('admin.allTeam');
      Route::get('/clone-team/{id}', [TeamAdminController::class, 'teamClonePage'])->name('admin.teamClonePage');
      Route::post('/clone-team', [TeamAdminController::class, 'cloneTeam'])->name('admin.cloneTeam');

      Route::get('/create-new-group/{id}', [TeamAdminController::class, 'createNewGroup'])->name('admin.createNewGroup');
      Route::post('/insert-new-group',[TeamAdminController::class, 'insertNewGroup'])->name('admin.insertNewGroup');
      Route::get('/all-group/{id}',[TeamAdminController::class, 'allGroup'])->name('admin.allGroup');
      Route::post('/updateMemberStatus',[TeamAdminController::class, 'updateMemberStatus'])->name('admin.updateMemberStatus');
      Route::get('/admin/getGroups', [TeamAdminController::class, 'getGroups'])->name('admin.getGroups');
      Route::post('/admin/reassignMember', [TeamAdminController::class, 'reassignMember'])->name('admin.reassignMember');
      Route::get('/download-groups/{id}', [TeamAdminController::class, 'downloadGroups'])->name('admin.downloadGroups');

      Route::get('/assign-new-members/{id}', [TeamAdminController::class, 'assignNewMembers'])->name('admin.assignNewMembers');

      Route::get('/member-position-details',[TeamAdminController::class, 'memberPositionDetails'])->name('admin.memberPositionDetails');
      Route::get('/download-position-history', [TeamAdminController::class, 'downloadPositionHistory'])->name('admin.downloadPositionHistory');
      Route::get('/import-members/{id}', [TeamAdminController::class, 'importMembersGroupPage'])->name('admin.importMembersGroupPage');
      Route::post('/import-groups/{id}', [TeamAdminController::class, 'importGroups'])->name('admin.importGroups');

      Route::get('/create-event',[EventAdminController::class, 'eventCreate'])->name('admin.eventCreate');
      Route::post('/insert-event',[EventAdminController::class, 'insertEvent'])->name('admin.insertEvent');
      Route::get('event-listing',[EventAdminController::class, 'eventListing'])->name('admin.eventListing');
      Route::delete('/delete-event', [EventAdminController::class, 'deleteEvent'])->name('admin.deleteEvent');
      Route::get('/edit-event/{eventId}', [EventAdminController::class, 'editEvent'])->name('admin.editEvent');
      Route::post('/update-event/{eventId}', [EventAdminController::class, 'updateEvent'])->name('admin.updateEvent');
      Route::get('/event-details/{eventId}', [EventAdminController::class, 'eventDetails'])->name('admin.eventDetails');
      Route::get('/event-interested-members/{eventId}', [EventAdminController::class, 'interestedMembers'])->name('admin.interestedMembers');
   });
});
Route::post('/upload', [NewsAdminController::class, 'upload'])->name('admin.upload')->middleware('https');

// Route::middleware(['adminLoggedIn'])->group(function () {
//    Route::get('/members', [Member::class, 'allMembers'])->name('allMembers');
//    Route::get('/members_pagination', [Member::class, 'paginateMember'])->name('allMembers.pagination');
//    Route::get('/members_search', [Member::class, 'searchMember'])->name('allMembers.search');
//    Route::get('/members/suggestions', [Member::class, 'suggestMembers'])->name('allMembers.suggestions');
//    Route::get('/members_filter', [Member::class, 'filterMember'])->name('allMembers.filter');

   

//    Route::get('/add-member', [Member::class, 'addMember'])->name('addMember');
//    Route::post('/insert-member', [Member::class, 'insertMember'])->name('insertMember');
//    Route::get('/admin/view', [Member::class, 'view'])->name('admin.view');
   
   
//    Route::get('/download-member/{id}', [Member::class, 'downloadMemberData'])->name('downloadMemberData');
// });

Route::middleware(['userLoggedIn'])->group(function () {
   
   Route::get('/add-member-session', [UserController::class, 'addMemberSession'])->name('add-member-session');
   
   Route::get('/member-details', [UserController::class, 'memberDetails'])->name('memberDetails');
   Route::post('/update-member-session', [UserController::class, 'updateMemberSession'])->name('update-member-session');

   Route::get('/see-all-news', [NewsUserController::class, 'seeAllNews'])->name('seeAllNews');
   Route::get('/news-details/{newsId}', [NewsUserController::class, 'newsDetails'])->name('user.newsDetails');

   Route::get('/see-all-birthdays', [BirthdayUserController::class, 'seeAllBirthdays'])->name('seeAllBirthdays');
   Route::get('/check-positions', [TeamUserController::class, 'positionDetails'])->name('positionDetails');

   Route::get('/all-events', [EventUserController::class, 'allEvents'])->name('allEvents');
   Route::post('/event/interested/{eventId}', [EventUserController::class, 'markInterested'])->name('event.markInterested');
});
Route::get('/view', [UserController::class, 'view'])->name('view');

Route::get('/login',[UserController::class, 'login'])->name('login')->middleware('user.redirect');
Route::post('/save', [UserController::class, 'save']);
Route::post('/verifyAndLogin', [UserController::class, 'verifyAndLogin']);

Route::get('/logout', [UserController::class, 'logout'])->name('logout');


Route::post('/generate-member-pdf', [adminController::class, 'generateMemberPdf'])->name('generate.member.pdf');


Route::prefix('chiefadmin')->group(function () {
   Route::get('/login',[ChiefadminController::class, 'login'])->name('chiefadmin.login')->middleware('chiefadmin.redirect');

   Route::post('/save', [ChiefadminController::class, 'save'])->name('chiefadmin.save');
   Route::post('/verifyAndLogin', [ChiefadminController::class, 'verifyAndLogin'])->name('chiefadmin.verifyAndLogin');
   Route::get('/logout', [ChiefadminController::class, 'logout'])->name('chiefadmin.logout');

   Route::middleware(['chiefadminLoggedIn'])->group(function () {
      Route::get('/dashboard', [ChiefadminController::class, 'dashboard'])->name('chiefadmin.dashboard');
      Route::get('/dashboard_pagination', [ChiefadminController::class, 'paginateDashboard'])->name('chiefadmin.pagination');
      Route::get('/dashboard_search', [ChiefadminController::class, 'searchDashboard'])->name('chiefadmin.search');
      Route::get('/add-organizer', [ChiefadminController::class, 'addOrganizer'])->name('chiefadmin.addOrganizer');
      Route::post('/insert-organizer', [ChiefadminController::class, 'insertOrganizer'])->name('chiefadmin.insertOrganizer');

      Route::get('/edit-organizer/{id}', [ChiefadminController::class, 'editOrganizer'])->name('chiefadmin.editOrganizer');
      Route::post('/update-organizer', [ChiefadminController::class, 'updateOrganizer'])->name('chiefadmin.updateOrganizer');
      Route::delete('/delete-organizer', [ChiefadminController::class, 'deleteOrganizer'])->name('chiefadmin.deleteOrganizer');
   });

});