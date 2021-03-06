<?php
use Services\interfaces\ILikeService;
use Services\interfaces\INotificationService;
use Repositories\interfaces\IUserRepository;
/**
 * Class LikeController
 */
class LikeController extends \BaseController
{

    /**
     * @var LikeService
     */
    private $likeService;

    private $notificationService;

    private $userRepository;

    /**
     * @param LikeService $likeService
     * @param NotificationService $notificationService
     */
    function __construct(ILikeService $likeService, INotificationService $notificationService, IUserRepository $userRepository)
    {
        $this->likeService = $likeService;
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
    }


    /**
     * Display a listing of the resource.
     * GET /like
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /like/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /like
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /like/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /like/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /like/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /like/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @param $type
     * @param $user_id
     * @return mixed
     */
    public function likePost($id, $type, $user_id)
    {
        $this->likeService->likeOrDislike(0, $id, $type, $user_id);
        if ($type == 1){
            $notification = $this->notificationService->create(array(
                'type_id' => $id,
                'user_id' => $user_id,
                'action' => 'like'
            ));
            $notification['username'] = $this->userRepository->get($notification->user_id)->username;
            $notification['list_user'] =  $this->notificationService->userEffectedPost($notification->post_id);

            Event::fire(NotificationEventHandler::EVENT, array(
                'notification' => $notification,
            ));
        }
        return Response::json(array(
            'success' => true
        ));
    }

    /**
     * @param $id
     * @param $type
     * @param $user_id
     * @return mixed
     */
    public function likeShop($id, $type, $user_id)
    {
        $this->likeService->likeOrDislike(1, $id, $type, $user_id);
        return Response::json(array(
            'success' => true
        ));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function countLikePost($id)
    {
        $count = $this->likeService->countLike(0, $id);

        return Response::json(array(
            'success' => true,
            'like' => $count
        ));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function countLikeShop($id)
    {
        $count = $this->likeService->countLike(1, $id);

        return Response::json(array(
            'success' => true,
            'like' => $count
        ));
    }
}