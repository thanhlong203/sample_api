<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use App\Controller\Component\PhpAesCipher;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class AccountController extends AppController
{
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function login()
    {
        if (!$this->request->isPost()) {
            $response = $this->response->withStatus(405);
            return $response;
        }
        $data = $this->request->getData();
        if (!$data['displayName'] || !$data['password'] || !$data['email']) {
            $response = $this->response->withStatus(500);
            return $response;
        }
        $response = $data;
        $response['id'] = 1;
        $response['walletAddress'] = "xkjhfgkhsdfjhgsdhfgsdf";
        unset($response['password']);
        echo json_encode($response);
        exit();
    }

    public function info() {
        if (!$this->request->isPost()) {
            $response = $this->response->withStatus(405);
            return $response;
        }
        $loginId = $this->request->getParam('loginId');
        if (!$loginId) {
            $response = $this->response->withStatus(500);
            return $response;
        }

        $res = ['id' => 1, 'companyId' => 1, 'displayName' => 'awesome company', 'email' => 'test@gmail.com', 'lang' => 1, 'walletAddress'=>'xkjhfgkhsdfjhgsdhfgsdf'];
        echo json_encode($res);
        exit();
    }

    public function update() {
        if (!$this->request->isPost()) {
            $response = $this->response->withStatus(405);
            return $response;
        }
        $data = $this->request->getData();
        if (!$data['id']) {
            $response = $this->response->withStatus(500);
            return $response;
        }
        $response = $data;
        $response['walletAddress'] = "xkjhfgkhsdfjhgsdhfgsdf";
        $response['companyId'] = "1";
        $response['email'] = "test@gmail.com";
        $response['lang'] = "1";
        unset($response['password']);
        echo json_encode($response);
        exit();
    }

    public function sso() {
        $data = $this->request->getData();
        $password = hash('sha256', $data['password']);
        $now= round(microtime(true) * 1000);
        $encryptObj = (object) ['password' => $password, 'email' => $data['email'], 'time' => $now];
        $hash = PhpAesCipher::encrypt("@rtrans$2022", "artg3ne$2022", json_encode($encryptObj));
        return $this->redirect("https://homepage-artnft-uat.bluebelt.asia?hash=".$hash.'&time='.$now);
    }
}
