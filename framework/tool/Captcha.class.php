<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/8/1
 * Time: 上午8:28
 */

class Captcha {

    /**
     * 生成验证码
     * @param int $code_len 长度
     */
    public function generate ($code_len=4){

        $chars = 'ABCDEFGHIGKLMNPQRSTUVWXYZ123456789';
        $chars_len = strlen($chars);
        $code = '';

        for ($i = 0; $i < $code_len; $i++){
            $rand_index = mt_rand(0, $chars_len-1);
            $code .= $chars[$rand_index];
        }

        // 存储于session，用于验证
        // 保证session机制一定是开启的，同时重复开启不会报错，@屏蔽错误
        @session_start();
        $_SESSION['captcha_code'] = $code;

        // 背景图
        $bg_file = TOOL_PATH.'captcha/captcha_bg'.mt_rand(1, 5).'.jpg';

        // 基于jpg格式的图片创建画布
        $img = imagecreatefromjpeg($bg_file);
        $color_black = imagecolorallocate($img, 0, 0, 0);
        $color_white = imagecolorallocate($img, 0xff, 0xff, 0xff);

        // 随机分配字符串颜色
        $str_color = mt_rand(1, 3) == 1 ? $color_black : $color_white;

        // 将字符串写到图片上
        $font = 5;

        // 画布的尺寸
        $img_w = imagesx($img);
        $img_h = imagesy($img);

        // 字体的尺寸
        $font_w = imagefontwidth($font);
        $font_h = imagefontheight($font);

        // 字符串的尺寸
        $code_w = $font_w * $code_len;
        $code_h = $font_h;

        // 字符串在图片上的位置
        $x = ($img_w - $code_w) / 2;
        $y = ($img_h - $code_h) / 2;

        imagestring($img, $font, $x, $y, $code, $str_color);

        // 输出
        header('Content-Type: image/jpeg;');
        imagejpeg($img);

        // 销毁
        imagedestroy($img);
    }


    /**
     * 验证
     * @param $request_code 用户提交的验证码
     * @return bool 是否匹配
     */
    public function checkCaptcha($request_code){

        @session_start();
        // strcasecmp() 不区分字符串大小写的比较，为0时表示相等，为正时表示第一个大，为负时相反
        $result = isset($request_code) && isset($_SESSION['captcha_code']) && (strcasecmp($request_code, $_SESSION['captcha_code']) == 0);
        unset($_SESSION['captcha_code']);
        return $result;
    }
}