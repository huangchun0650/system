<?php

namespace YFDev\System\App\Services\Notification;

use Illuminate\Auth\AuthManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use YFDev\System\App\Http\Transforms\Models\NotificationTransform;
use YFDev\System\App\Repositories\Notification\NotificationRepositoryInterface;
use YFDev\System\App\Services\BaseService;

class NotificationService extends BaseService
{
    protected $notificationRepository;

    protected $auth;

    public function __construct(NotificationRepositoryInterface $notificationRepository, AuthManager $auth)
    {
        $this->notificationRepository = $notificationRepository;
        $this->auth = $auth;
    }

    /**
     * list
     */
    public function list(): JsonResponse
    {
        $list = $this->auth->user()->notifications()->orderBy('created_at', 'desc')->get();

        return NotificationTransform::response(compact('list'));
    }

    /**
     * readIds
     */
    public function readIds(): JsonResponse
    {
        $notifications = $this->auth->user()->notifications()->whereIn('id', request()->input('notifyIds'));

        $notifications->update(['isRead' => true]);

        return json_response()->success([
            'message' => 'Notification Read Successfully',
        ]);
    }

    /**
     * deleteIds
     */
    public function deleteIds(): JsonResponse
    {
        $notifications = $this->auth->user()->notifications()->whereIn('id', request()->input('notifyIds'));
        $notifications->delete();

        return json_response()->success([
            'message' => 'Notification Delete Successfully',
        ]);
    }

    /**
     * readAll
     */
    public function readAll(): JsonResponse
    {
        $this->auth->user()->notifications()->where('isRead', 0)->update(['isRead' => true]);

        return json_response()->success([
            'message' => 'Notification Read All Successfully',
        ]);
    }
}
