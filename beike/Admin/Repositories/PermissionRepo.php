<?php
/**
 * PermissionRepo.php
 *
 * @copyright  2022 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Edward Yang <yangjin@opencart.cn>
 * @created    2022-08-01 20:49:45
 * @modified   2022-08-01 20:49:45
 */

namespace Beike\Admin\Repositories;

use Beike\Models\AdminUser;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class PermissionRepo
{
    private ?AdminUser $adminUser = null;
    private ?Role $adminRole = null;

    public function setUser(AdminUser $user): PermissionRepo
    {
        $this->adminUser = $user;
        return $this;
    }

    public function setRole(Role $role): PermissionRepo
    {
        $this->adminRole = $role;
        return $this;
    }

    /**
     * 所有权限列表
     *
     * @return \string[][][]
     */
    public function getAllPermissions(): array
    {
        $permissions = [
            ['title' => trans('admin/common.order'), 'permissions' => $this->getOrderPermissions()],
            ['title' => trans('admin/common.product'), 'permissions' => $this->getProductPermissions()],
            ['title' => trans('admin/common.category'), 'permissions' => $this->getCategoryPermissions()],
            ['title' => trans('admin/common.brand'), 'permissions' => $this->getBrandPermissions()],
            ['title' => trans('admin/common.customer'), 'permissions' => $this->getCustomerPermissions()],
            ['title' => trans('admin/common.customer_group'), 'permissions' => $this->getCustomerGroupPermissions()],
            ['title' => trans('admin/common.content'), 'permissions' => $this->getContentPermissions()],
            ['title' => trans('admin/common.setting'), 'permissions' => $this->getSettingPermissions()],

            ['title' => trans('admin/common.plugin'), 'permissions' => $this->getPluginPermissions()],
            ['title' => trans('admin/common.admin_user'), 'permissions' => $this->getAdminUserPermissions()],
            ['title' => trans('admin/common.region'), 'permissions' => $this->getRegionPermissions()],
            ['title' => trans('admin/common.tax_rate'), 'permissions' => $this->getTaxRatePermissions()],
            ['title' => trans('admin/common.tax_class'), 'permissions' => $this->getTaxClassPermissions()],
            ['title' => trans('admin/common.currency'), 'permissions' => $this->getCurrencyPermissions()],
            ['title' => trans('admin/common.language'), 'permissions' => $this->getLanguagePermissions()],
        ];
        return hook_filter('role.all_permissions', $permissions);
    }


    /**
     * 订单权限列表
     *
     * @return \string[][]
     */
    private function getOrderPermissions(): array
    {
        $routes = ['orders_index', 'orders_create', 'orders_show', 'orders_update', 'orders_delete'];
        $items = $this->getPermissionList('order', $routes);
        return hook_filter('role.order_permissions', $items);
    }


    /**
     * 商品权限列表
     *
     * @return \string[][]
     */
    private function getProductPermissions(): array
    {
        $routes = ['products_index', 'products_create', 'products_show', 'products_update', 'products_delete', 'products_trashed'];
        $items = $this->getPermissionList('product', $routes);
        return hook_filter('role.product_permissions', $items);
    }


    /**
     * 分类权限列表
     *
     * @return \string[][]
     */
    private function getCategoryPermissions(): array
    {
        $routes = ['categories_index', 'categories_create', 'categories_show', 'categories_update', 'categories_delete'];
        $items = $this->getPermissionList('category', $routes);
        return hook_filter('role.category_permissions', $items);
    }


    /**
     * 品牌权限列表
     *
     * @return \string[][]
     */
    private function getBrandPermissions(): array
    {
        $routes = ['brands_index', 'brands_create', 'brands_show', 'brands_update', 'brands_delete'];
        $items = $this->getPermissionList('brand', $routes);
        return hook_filter('role.brand_permissions', $items);
    }


    /**
     * 客户权限列表
     *
     * @return \string[][]
     */
    private function getCustomerPermissions(): array
    {
        $routes = ['customers_index', 'customers_create', 'customers_show', 'customers_update', 'customers_delete'];
        $items = $this->getPermissionList('customer', $routes);
        return hook_filter('role.customer_permissions', $items);
    }


    /**
     * 客户组权限列表
     *
     * @return \string[][]
     */
    private function getCustomerGroupPermissions(): array
    {
        $routes = ['customer_groups_index', 'customer_groups_create', 'customer_groups_show', 'customer_groups_update', 'customer_groups_delete'];
        $items = $this->getPermissionList('customer_group', $routes);
        return hook_filter('role.customer_group_permissions', $items);
    }


    /**
     * 设置权限列表
     *
     * @return \string[][]
     */
    private function getSettingPermissions(): array
    {
        $routes = ['settings_index', 'design_index', 'design_footer_index'];
        $items = $this->getPermissionList('setting', $routes);
        return hook_filter('role.setting_permissions', $items);
    }


    /**
     * 内容管理列表
     * @return mixed
     */
    private function getContentPermissions()
    {
        $routes = ['pages_index', 'pages_create', 'pages_show', 'pages_update', 'pages_delete'];
        $items = $this->getPermissionList('page', $routes);
        return hook_filter('role.page_permissions', $items);
    }


    /**
     * 插件权限列表
     *
     * @return array[]
     */
    private function getPluginPermissions(): array
    {
        $routes = ['plugins_index', 'plugins_import', 'plugins_update', 'plugins_show', 'plugins_install', 'plugins_update_status', 'plugins_uninstall'];
        $items = $this->getPermissionList('plugin', $routes);
        return hook_filter('role.plugin_permissions', $items);
    }


    /**
     * 后台管理员权限列表
     *
     * @return mixed
     */
    private function getAdminUserPermissions()
    {
        $routes = ['admin_users_index', 'admin_users_create', 'admin_users_show', 'admin_users_update', 'admin_users_delete'];
        $items = $this->getPermissionList('user', $routes);
        return hook_filter('role.user_permissions', $items);
    }


    /**
     * 区域分组权限列表
     *
     * @return array[]
     */
    private function getRegionPermissions(): array
    {
        $routes = ['regions_index', 'regions_create', 'regions_show', 'regions_update', 'regions_delete'];
        $items = $this->getPermissionList('region', $routes);
        return hook_filter('role.region_permissions', $items);
    }


    /**
     * 获取税率权限列表
     *
     * @return array[]
     */
    private function getTaxRatePermissions(): array
    {
        $routes = ['tax_rates_index', 'tax_rates_create', 'tax_rates_show', 'tax_rates_update', 'tax_rates_delete'];
        $items = $this->getPermissionList('tax_rate', $routes);
        return hook_filter('role.tax_rate_permissions', $items);
    }


    /**
     * 获取税类权限列表
     *
     * @return array[]
     */
    private function getTaxClassPermissions(): array
    {
        $routes = ['tax_classes_index', 'tax_classes_create', 'tax_classes_show', 'tax_classes_update', 'tax_classes_delete'];
        $items = $this->getPermissionList('tax_class', $routes);
        return hook_filter('role.tax_class_permissions', $items);
    }


    /**
     * 获取汇率权限列表
     *
     * @return array[]
     */
    private function getCurrencyPermissions(): array
    {
        $routes = ['currencies_index', 'currencies_create', 'currencies_show', 'currencies_update', 'currencies_delete'];
        $items = $this->getPermissionList('currency', $routes);
        return hook_filter('role.currency_permissions', $items);
    }


    /**
     * 获取语言权限列表
     *
     * @return array[]
     */
    private function getLanguagePermissions(): array
    {
        $routes = ['languages_index', 'languages_create', 'languages_show', 'languages_update', 'languages_delete'];
        $items = $this->getPermissionList('language', $routes);
        return hook_filter('role.language_permissions', $items);
    }


    /**
     * 根据模块和路由返回权限列表
     *
     * @param $module
     * @param $routes
     * @return array
     */
    private function getPermissionList($module, $routes): array
    {
        $items = [];
        foreach ($routes as $route) {
            $items[] = ['code' => $route, 'name' => trans("admin/{$module}.{$route}"), 'selected' => $this->hasPermission($route)];
        }
        return $items;
    }

    /**
     * 判断当前用户或者角色是否有权限
     *
     * @param $permission
     * @return bool
     */
    private function hasPermission($permission): bool
    {
        try {
            if ($this->adminRole) {
                return $this->adminRole->hasPermissionTo($permission);
            } elseif ($this->adminUser) {
                return $this->adminUser->can($permission);
            }
        } catch (PermissionDoesNotExist $exception) {
            return false;
        }
        return false;
    }
}
