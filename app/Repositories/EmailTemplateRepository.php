<?php
namespace App\Repositories;

use App\Models\EmailTemplate;

class EmailTemplateRepository
{
    protected $emailTemplate;

    public function __construct(EmailTemplate $emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    public function getEmailTemplates()
    {
        return $this->emailTemplate->all();
    }

    public function getEmailTemplateById($id)
    {
        return $this->emailTemplate->find($id);
    }

    public function createEmailTemplate($data)
    {
        return $this->emailTemplate->create($data);
    }

    public function updateEmailTemplate($id, $data)
    {
        return $this->emailTemplate->find($id)->update($data);
    }

    public function deleteEmailTemplate($id)
    {
        return $this->emailTemplate->find($id)->delete();
    }

    public function deleteSelectedEmailTemplates($ids)
    {
        return $this->emailTemplate->whereIn('id', $ids)->delete();
    }



}