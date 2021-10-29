<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ConfigSave extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // invite & commission
            'safe_mode_enable' => 'in:0,1',
            'invite_force' => 'in:0,1',
            'invite_commission' => 'integer',
            'invite_gen_limit' => 'integer',
            'invite_never_expire' => 'in:0,1',
            'commission_first_time_enable' => 'in:0,1',
            'commission_auto_check_enable' => 'in:0,1',
            'commission_withdraw_limit' => 'nullable|numeric',
            'commission_withdraw_method' => 'nullable|array',
            'withdraw_close_enable' => 'in:0,1',
            'package_plan_id' => 'integer',
            'package_cycle' => 'in:onetime_price,reset_price,month_price,quarter_price,half_year_price,year_price,two_year_price,three_year_price',
            'package_limit' => 'integer|min:1',
            'package_recovery_limit' => 'integer|min:1',
            // site
            'stop_register' => 'in:0,1',
            'email_verify' => 'in:0,1',
            'app_name' => '',
            'app_description' => '',
            'app_url' => 'nullable|url',
            'subscribe_url' => 'nullable',
            'try_out_enable' => 'in:0,1',
            'try_out_plan_id' => 'integer',
            'try_out_hour' => 'numeric',
            'email_whitelist_enable' => 'in:0,1',
            'email_whitelist_suffix' => 'nullable|array',
            'email_gmail_limit_enable' => 'in:0,1',
            'recaptcha_enable' => 'in:0,1',
            'recaptcha_key' => '',
            'recaptcha_site_key' => '',
            'tos_url' => 'nullable|url',
            // subscribe
            'plan_change_enable' => 'in:0,1',
            'reset_traffic_method' => 'in:0,1',
            'surplus_enable' => 'in:0,1',
            'reset_onetime_traffic_enable' => 'in:0,1',
            // server
            'server_token' => 'nullable|min:16',
            'server_license' => 'nullable',
            'server_log_enable' => 'in:0,1',
            'server_v2ray_domain' => '',
            'server_v2ray_protocol' => '',
            // frontend
            'frontend_theme' => '',
            'frontend_theme_sidebar' => 'in:dark,light',
            'frontend_theme_header' => 'in:dark,light',
            'frontend_theme_color' => 'in:default,darkblue,black,green',
            'frontend_background_url' => 'nullable|url',
            'frontend_admin_path' => '',
            'frontend_customer_service_method' => '',
            'frontend_customer_service_id' => '',
            // email
            'email_template' => '',
            'email_host' => '',
            'email_port' => '',
            'email_username' => '',
            'email_password' => '',
            'email_encryption' => '',
            'email_from_address' => '',
            // telegram
            'telegram_bot_enable' => 'in:0,1',
            'telegram_bot_token' => '',
            'telegram_discuss_id' => '',
            'telegram_channel_id' => '',
            // app
            'windows_version' => '',
            'windows_download_url' => '',
            'macos_version' => '',
            'macos_download_url' => '',
            'android_version' => '',
            'android_download_url' => ''
        ];
    }

    public function messages()
    {
        // illiteracy prompt
        return [
            'app_url.url' => '站点URL格式不正确，必须携带http(s)://',
            'subscribe_url.url' => '订阅URL格式不正确，必须携带http(s)://',
            'server_token.min' => '通讯密钥长度必须大于16位',
            'tos_url.url' => '服务条款URL格式不正确',
        ];
    }
}
