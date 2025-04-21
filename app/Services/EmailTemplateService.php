<?php

    namespace App\Services;

    use App\Repositories\EmailTemplateRepository;

    class EmailTemplateService
    {
    protected $emailTemplateRepository;

    public function __construct(EmailTemplateRepository $emailTemplateRepository)
    {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    public function getEmailTemplateById($id)
    {
        return $this->emailTemplateRepository->getEmailTemplateById($id);
    }

    public function getEmailTemplates()
    {
        return $this->emailTemplateRepository->getEmailTemplates();
    }

    public function createEmailTemplate($data)
    {
        return $this->emailTemplateRepository->createEmailTemplate($data);
    }

    public function updateEmailTemplate($id, $data)
    {

        return $this->emailTemplateRepository->updateEmailTemplate($id, $data);
    }

    public function deleteEmailTemplate($id)
    {
        return $this->emailTemplateRepository->deleteEmailTemplate($id);
    }

    // public function normalizeString($string)
    // {
    //     if($string == null){
    //         return null;
    //     }
    //     // Remove extra whitespace
    //     $string = trim($string);

    //     // Convert to lowercase
    //     $string = strtolower($string);

    //     // Remove special characters and keep only alphanumeric and spaces
    //     $string = preg_replace('/[^a-z0-9\s]/', '', $string);

    //     // Replace multiple spaces with single space
    //     $string = preg_replace('/\s+/', ' ', $string);

    //     return $string;
    // }
    public function deleteSelectedEmailTemplates($ids)
    {
        $ids = json_decode($ids->selected_ids, true);
        return $this->emailTemplateRepository->deleteSelectedEmailTemplates($ids);
    }
}