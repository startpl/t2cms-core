<?php

namespace t2cms\user\backend\controllers;

use yii\web\Controller;
use t2cms\user\common\useCases\RoleService;
use t2cms\user\common\repositories\{
    PermissionRepository,
    RoleRepository
};

/**
 * PermissionsController implements the CRUD actions for AuthItem model.
 */
class PermissionsController extends Controller
{
    private $roleService;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'panelAccess' => [
                'class' => \t2cms\base\behaviors\AdminPanelAccessControl::className()
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manageRBAC'],
                    ],
                ],
            ],
        ];
    }
    
    public function __construct($id, $module, RoleService $roleService, $config = array()) 
    {
        parent::__construct($id, $module, $config);
        
        $this->roleService = $roleService;
    }
    
    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {                
        $permissions = PermissionRepository::getAll();
        $roles       = RoleRepository::getAll();
        
        if(\Yii::$app->request->post()){
            if($this->roleService->assignPermissions(\Yii::$app->request->post(), $permissions, $roles)){
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success save'));
                return $this->refresh();
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error save'));
            }
        }        
        
        return $this->render('index', [
            'permissions' => $permissions,
            'roles'       => $roles
        ]);
    }
    
}
