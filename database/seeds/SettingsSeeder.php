<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting();
        $setting->title = 'عنوان سایت';
        $setting->category_id = '18';
        $setting->description = 'عنوان سایت شما که در بالای سایت نمایش داده می شود.';
        $setting->key = 'platform.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلمات کلیدی';
        $setting->category_id = '18';
        $setting->description = 'کلمات کلیدی وب سایت شما برای بهینه سازی موتور جستجو نیاز است.';
        $setting->key = 'platform.keywords';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'توضیحات';
        $setting->category_id = '18';
        $setting->description = 'توضیحات مختصری در مورد وب سایت شما برای بهینه سازی موتور جستجو نیاز است.';
        $setting->key = 'platform.description';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'آیکون سایت';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.main-icon';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'ترکیب رنگ نوار بالایی';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.navbar-type';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'ترکیب رنگ نوار پایینی';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.navbar-bottom-type';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'آدرس سیستم مدیریت سیستم';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.admin-route';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'صفحه ورود پیشفرض';
        $setting->category_id = '18';
        $setting->description = 'پس از اینکه کاربر وارد یا در سایت ثبت نام کرد به چه صفحه ای برود.';
        $setting->key = 'platform.redirectTo';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلاس محتوایی';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.main-container';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلاس محتوایی نوار بالا و پایین';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.navbar-container';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'مدت زمان کش';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.cache-time';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن ثبت نام';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.register-enabled';
        $setting->type = 'enable';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'نوع موقعیت نوار بالایی';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.header-position';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'نوع موقعیت نوار پایینی';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.footer-position';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'صفحه فرود یا اولیه';
        $setting->category_id = 21;
        $setting->description = '';
        $setting->key = 'platform.index-page-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'pages', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'صفحه ارتباط با ما';
        $setting->category_id = 21;
        $setting->description = '';
        $setting->key = 'platform.contact-us-page-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'pages', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'صفحه درباره ما';
        $setting->category_id = 21;
        $setting->description = '';
        $setting->key = 'platform.about-us-page-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'pages', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'قوانین و مقررات';
        $setting->category_id = 21;
        $setting->description = '';
        $setting->key = 'platform.tos-page-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'pages', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'ثبت شکایت';
        $setting->category_id = 21;
        $setting->description = '';
        $setting->key = 'platform.complaint-page-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'pages', 'attrib' => 'title'];
        $setting->save();


        $setting = new Setting();
        $setting->title = 'مدیر اصلی سایت';
        $setting->category_id = '18';
        $setting->description = '';
        $setting->key = 'platform.main-admin-user-id';
        $setting->type = 'select-model';
        $setting->options = ['model'=> '\App\Models\User', 'attrib' => 'name'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن زرین پال';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.zarinpal.active';
        $setting->type = 'yesno';
        $setting->save();



        //Gateways

        $setting = new Setting();
        $setting->title = 'فعال بودن درگاه به پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.mellat.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به درگاه به پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.mellat.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه به پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.mellat.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'نام کاربری به پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.mellat.username';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلمه عبور به پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.mellat.password';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'شماره ترمینال به پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.mellat.terminalId';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'ترتیب  به پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.mellat.order';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به زرین پال';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.zarinpal.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه زرین پال';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.zarinpal.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Merchant ID زرین پال';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.zarinpal.merchant-id';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'نوع درگاه زرین پال';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.zarinpal.type';
        $setting->type = 'select';
        $setting->options = ['zarin-gate'=>'Zarin Gate','normal'=>'Normal'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'سرور زرین پال';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.zarinpal.server';
        $setting->type = 'select';
        $setting->options = ['germany'=>'آلمان','test'=>'تست','iran'=>'ایران'];
        $setting->save();


        $setting = new Setting();
        $setting->title = 'فعال بودن درگاه سامان کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saman.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به درگاه سامان کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saman.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه سامان کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saman.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Merchant سامان کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saman.merchant';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Password سامان کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saman.password';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن مبنا کارت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saderat.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به مبنا کارت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saderat.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه منبا کارت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saderat.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Merchant مبنا کارت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saderat.merchant-id';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Terminal مبنا کارت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saderat.terminal-id';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلید عمومی مبنا کارت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saderat.public-key';
        $setting->type = 'file';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلید خصوصی مبنا کارت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.saderat.private-key';
        $setting->type = 'file';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن ایران کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.irankish.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه ایران کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.irankish.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به ایران کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.irankish.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Merchant ID ایران کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.irankish.merchant-id';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'SHA1 KEY ایران کیش';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.irankish.sha1-key';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن Payir';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.payir.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به Payir';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.payir.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه Payir';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.payir.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'API Payir';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.payir.api';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن سداد ملی';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.sadad.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به سداد ملی';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.sadad.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه سداد ملی';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.sadad.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'شماره Merchant سداد ملی';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.sadad.merchant';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلید تراکنش سداد ملی';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.sadad.transactionKey';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Terminal ID سداد ملی';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.sadad.terminalId';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.asanpardakht.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.asanpardakht.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.asanpardakht.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'شماره Merchant آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.sadad.merchantId';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'شماره Merchant Config آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.asanpardakht.merchantConfigId';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'نام کاربری آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.asanpardakht.username';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلمه عبور آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.asanpardakht.password';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'کلید آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.asanpardakht.key';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'IV آسان پرداخت';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.asanpardakht.iv';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن پارسیان';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.parsian.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به پارسیان';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.parsian.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه پارسیان';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.parsian.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'PIN پارسیان';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.parsian.pin';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'فعال بودن پاسارگاد';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.pasargad.active';
        $setting->type = 'yesno';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'حساب متصل به پاسارگاد';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.pasargad.account-id';
        $setting->type = 'select-table';
        $setting->options = ['table'=> 'accounts', 'attrib' => 'title'];
        $setting->save();

        $setting = new Setting();
        $setting->title = 'عنوان درگاه پاسارگاد';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.pasargad.name';
        $setting->type = 'text';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Terminal ID پاسارگاد';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.pasargad.terminalId';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Merchant ID پاسارگاد';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.pasargad.merchantId';
        $setting->type = 'text-ltr';
        $setting->save();

        $setting = new Setting();
        $setting->title = 'Certificate پاسارگاد';
        $setting->category_id = 19;
        $setting->description = '';
        $setting->key = 'gateways.pasargad.certificate-path';
        $setting->type = 'file';
        $setting->save();
    }
}
