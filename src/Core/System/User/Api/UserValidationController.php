<?php declare(strict_types=1);

namespace Shopware\Core\System\User\Api;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Routing\Exception\MissingRequestParameterException;
use Shopware\Core\System\User\Service\UserValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"api"})
 */
class UserValidationController extends AbstractController
{
    /**
     * @var UserValidationService
     */
    private $userValidationService;

    public function __construct(
        UserValidationService $userValidationService
    ) {
        $this->userValidationService = $userValidationService;
    }

    /**
     * @Route("api/v{version}/_action/user/check-email-unique", name="api.action.check-email-unique", methods={"POST"})
     *
     * @throws MissingRequestParameterException
     */
    public function isEmailUnique(Request $request, Context $context): JsonResponse
    {
        if (!$request->request->has('email')) {
            throw new MissingRequestParameterException('email');
        }

        if (!$request->request->has('id')) {
            throw new MissingRequestParameterException('id');
        }

        $email = $request->request->get('email');
        $id = $request->request->get('id');

        return new JsonResponse(
            ['emailIsUnique' => $this->userValidationService->checkEmailUnique($email, $id, $context)]
        );
    }

    /**
     * @Route("api/v{version}/_action/user/check-username-unique", name="api.action.check-username-unique", methods={"POST"})
     *
     * @throws MissingRequestParameterException
     */
    public function isUsernameUnique(Request $request, Context $context): JsonResponse
    {
        if (!$request->request->has('username')) {
            throw new MissingRequestParameterException('username');
        }

        if (!$request->request->has('id')) {
            throw new MissingRequestParameterException('id');
        }

        $username = $request->request->get('username');
        $id = $request->request->get('id');

        return new JsonResponse(
            ['usernameIsUnique' => $this->userValidationService->checkUsernameUnique($username, $id, $context)]
        );
    }
}
