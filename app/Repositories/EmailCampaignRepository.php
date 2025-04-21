<?php
namespace App\Repositories;

use App\Models\EmailCampaign;

class EmailCampaignRepository
{
    protected $emailCampaign;

    public function __construct(EmailCampaign $emailCampaign)
    {
        $this->emailCampaign = $emailCampaign;
    }

    public function getEmailCampaigns()
    {
        return $this->emailCampaign->all();
    }

    public function createEmailCampaign($data){
        return $this->emailCampaign->create($data);
    }

    public function deleteEmailCampaign($id){
        return $this->emailCampaign->find($id)->delete();
    }

    public function deleteSelectedEmailCampaigns($data){
        return $this->emailCampaign->whereIn('id', $data)->delete();
    }

    public function getEmailCampaignById($id){
        return $this->emailCampaign->find($id);
    }

    public function updateEmailCampaign($id, $data){
        return $this->emailCampaign->find($id)->update($data);
    }
}