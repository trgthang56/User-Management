<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailTemplateService;

class EmailTemplateController extends Controller
{
    protected $emailTemplateService;

    public function __construct(EmailTemplateService $emailTemplateService)
    {
        $this->emailTemplateService = $emailTemplateService;
    }

    public function index(){
        $emailTemplates = $this->emailTemplateService->getEmailTemplates();
        return view('email_templates.index', [
            'emailTemplates' => $emailTemplates
        ]);
    }

    public function detailIndex($id){
        $emailTemplate = $this->emailTemplateService->getEmailTemplateById($id);
        return view('email_templates.detail', [
            'emailTemplate' => $emailTemplate
        ]);
    }

    public function updateIndex($id){
        $emailTemplate = $this->emailTemplateService->getEmailTemplateById($id);
        return view('email_templates.edit', [
            'emailTemplate' => $emailTemplate
        ]);
    }

    public function store(Request $request){
        $this->emailTemplateService->createEmailTemplate($request->all());
        return redirect()->route('email.template.list')->with('success', 'Email Template created successfully!');
    }

    public function update(Request $request){
        $this->emailTemplateService->updateEmailTemplate($request->id, $request->all());
        return redirect()->route('email.template.list')->with('success', 'Email Template updated successfully!');
    }

    public function delete(Request $request){
        $this->emailTemplateService->deleteEmailTemplate($request->id);
        return redirect()->route('email.template.list')->with('success', 'Email Template deleted successfully!');
    }

    public function deleteSelected(Request $request){
        $this->emailTemplateService->deleteSelectedEmailTemplates($request);
        return redirect()->route('email.template.list')->with('success', 'Email Templates deleted successfully!');
    }

}
