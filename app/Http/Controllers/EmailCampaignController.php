<?php

namespace App\Http\Controllers;

use App\Events\CheckCampaignStatus;
use Illuminate\Http\Request;
use App\Services\EmailCampaignService;
use App\Services\EmailTemplateService;
use App\Services\UserService;
use App\Services\TaskService;
class EmailCampaignController extends Controller
    {
    protected $emailCampaignService;
    protected $emailTemplateService;
    protected $userService;
    protected $taskService;

    public function __construct(EmailCampaignService $emailCampaignService, EmailTemplateService $emailTemplateService, UserService $userService, TaskService $taskService)
    {
        $this->emailCampaignService = $emailCampaignService;
        $this->emailTemplateService = $emailTemplateService;
        $this->userService = $userService;
        $this->taskService = $taskService;
    }
    public function index(){
        event(new CheckCampaignStatus());
        $emailCampaigns = $this->emailCampaignService->getEmailCampaigns();
        $emailTemplates = $this->emailTemplateService->getEmailTemplates();
        $users = $this->userService->getUsers();
        $tasks = $this->taskService->getTasks();
        return view('email_campaigns.index', [
            'emailCampaigns' => $emailCampaigns,
            'emailTemplates' => $emailTemplates,
            'users' => $users,
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request){
        $this->emailCampaignService->createEmailCampaign($request->all());
        return redirect()->route('email.campaign.list')->with('success', 'Email campaign created successfully');
    }

    public function destroy($id){
        $this->emailCampaignService->deleteEmailCampaign($id);
        return redirect()->route('email.campaign.list')->with('success', 'Email campaign deleted successfully');
    }

    public function destroySelected(Request $request){
        $this->emailCampaignService->deleteSelectedEmailCampaigns($request);
        return redirect()->route('email.campaign.list')->with('success', 'Email campaigns deleted successfully');
    }

    public function updateIndex($id){
        $emailCampaign = $this->emailCampaignService->getEmailCampaignById($id);
        $emailTemplates = $this->emailTemplateService->getEmailTemplates();
        $tasks = $this->taskService->getTasks();
        return view('email_campaigns.edit', [
            'emailCampaign' => $emailCampaign,
            'emailTemplates' => $emailTemplates,
            'tasks' => $tasks
        ]);
    }

    public function detailIndex($id){
        $emailCampaign = $this->emailCampaignService->getEmailCampaignById($id);
        $emailTemplates = $this->emailTemplateService->getEmailTemplates();
        $tasks = $this->taskService->getTasks();
        return view('email_campaigns.detail', [
            'emailCampaign' => $emailCampaign,
            'emailTemplates' => $emailTemplates,
            'tasks' => $tasks
        ]);
    }
    public function update(Request $request){
        $this->emailCampaignService->updateEmailCampaign($request->id, $request->all());
        return redirect()->route('email.campaign.list')->with('success', 'Email campaign updated successfully');
    }
}
