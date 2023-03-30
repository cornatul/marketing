<?php

declare(strict_types=1);

namespace Cornatul\Marketing\Base\Http\Requests\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Cornatul\Marketing\Base\Facades\MarketingPortal;
use Cornatul\Marketing\Base\Http\Requests\CampaignStoreRequest as BaseCampaignStoreRequest;
use Cornatul\Marketing\Base\Models\Campaign;
use Cornatul\Marketing\Base\Models\CampaignStatus;
use Cornatul\Marketing\Base\Repositories\Campaigns\CampaignTenantRepositoryInterface;
use Cornatul\Marketing\Base\Repositories\TagTenantRepository;

class CampaignStoreRequest extends BaseCampaignStoreRequest
{
    /**
     * @var CampaignTenantRepositoryInterface
     */
    protected $campaigns;

    public function __construct(CampaignTenantRepositoryInterface $campaigns)
    {
        parent::__construct();

        $this->campaigns = $campaigns;
        $this->workspaceId = MarketingPortal::currentWorkspaceId();

        Validator::extendImplicit('valid_status', function ($attribute, $value, $parameters, $validator) {
            return !$this->campaign || $this->getCampaign()->status_id === CampaignStatus::STATUS_DRAFT;
        });
    }

    /**
     * @throws \Exception
     */
    public function getCampaign(): Campaign
    {
        return $this->campaign = $this->campaigns->find($this->workspaceId, $this->campaign);
    }

    public function rules(): array
    {
        $tags = app(TagTenantRepository::class)->pluck(
            $this->workspaceId,
            'id'
        );

        $rules = [
            'send_to_all' => [
                'required',
                'boolean',
            ],
            'tags' => [
                'required_unless:send_to_all,1',
                'array',
                Rule::in($tags),
            ],
            'tags.*' => [
                'integer',
            ],
            'scheduled_at' => [
                'required',
                'date',
            ],
            'save_as_draft' => [
                'nullable',
                'boolean',
            ],
            'status_id' => 'valid_status',
        ];

        return array_merge($this->getRules(), $rules);
    }

    public function messages(): array
    {
        return [
            'valid_status' => __('A campaign cannot be updated if its status is not draft'),
            'tags.in' => 'One or more of the tags is invalid.',
        ];
    }
}
