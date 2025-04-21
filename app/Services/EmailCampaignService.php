<?php

namespace App\Services;

use App\Repositories\EmailCampaignRepository;

class EmailCampaignService
{
    protected $emailCampaignRepository;

    public function __construct(EmailCampaignRepository $emailCampaignRepository)
    {
        $this->emailCampaignRepository = $emailCampaignRepository;
    }

    public function getEmailCampaigns()
    {
        return $this->emailCampaignRepository->getEmailCampaigns();
    }

    public function createEmailCampaign($data){
        if(isset($data['task'])){
            $data['task_id'] = implode(',', $data['task']);
            unset($data['task']);
        } else {
            $data['task_id'] = null;
        }
        $data['status'] = '2';
        return $this->emailCampaignRepository->createEmailCampaign($data);
    }

    public function deleteEmailCampaign($id){
        return $this->emailCampaignRepository->deleteEmailCampaign($id);
    }

    public function deleteSelectedEmailCampaigns($data){
        $ids = json_decode($data->selected_ids, true);
        return $this->emailCampaignRepository->deleteSelectedEmailCampaigns($ids);
    }

    public function getEmailCampaignById($id){
        return $this->emailCampaignRepository->getEmailCampaignById($id);
    }

    public function updateEmailCampaign($id, $data){
        return $this->emailCampaignRepository->updateEmailCampaign($id, $data);
    }
}