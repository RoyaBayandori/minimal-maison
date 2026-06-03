<?php
/**
 * Homepage default copy and structured fallbacks.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default homepage text values keyed by field name.
 *
 * @return array<string, string>
 */
function mm_home_default_strings(): array {
	return array(
		'hero_eyebrow'              => __( 'مینیمال', 'minimal-maison' ),
		'hero_heading'              => __( 'طلاهایی که برای شما ساخته می‌شوند، نه برای ویترین', 'minimal-maison' ),
		'hero_description'          => __( 'در مینیمال هر قطعه بر اساس سلیقه، داستان و خواسته شما طراحی و ساخته می‌شود؛ از حلقه‌های ازدواج تا جواهرات کاملاً سفارشی.', 'minimal-maison' ),
		'hero_primary_cta_label'    => __( 'درخواست ساخت اختصاصی', 'minimal-maison' ),
		'hero_primary_cta_url'      => '#request',
		'hero_secondary_cta_label'  => __( 'مشاهده نمونه کارها', 'minimal-maison' ),
		'hero_secondary_cta_url'    => '#creations',
		'hero_banner_eyebrow'       => __( 'کارگاه', 'minimal-maison' ),
		'hero_banner_text'          => __( 'هر قطعه در کارگاه ما دست‌ساز است — با توجه به جزئیات، نه برای انبوه‌سازی.', 'minimal-maison' ),
		'craft_eyebrow'             => __( 'فرایند کارگاه', 'minimal-maison' ),
		'craft_heading'             => __( 'چگونه یک اثر اختصاصی ساخته می‌شود', 'minimal-maison' ),
		'craft_description'         => __( 'هر قطعه در چهار مرحله — از نخستین گفتگو تا لحظه تحویل.', 'minimal-maison' ),
		'creations_eyebrow'         => __( 'نمونه کارها', 'minimal-maison' ),
		'creations_heading'         => __( 'برخی از سفارش‌های اخیر', 'minimal-maison' ),
		'creations_description'     => __( 'هر قطعه بر اساس نام، سلیقه و داستان صاحب آن ساخته شده است.', 'minimal-maison' ),
		'process_heading'           => __( 'سفارش ساخت چگونه انجام می‌شود؟', 'minimal-maison' ),
		'process_description'     => __( 'از اولین جلسه مشاوره تا تحویل نهایی، هر مرحله شفاف و قابل پیگیری است. شما در طراحی مشارکت دارید و ما مسئولیت ساخت را بر عهده می‌گیریم.', 'minimal-maison' ),
		'testimonials_eyebrow'      => __( 'تجربه مشتریان', 'minimal-maison' ),
		'testimonials_heading'      => __( 'سفارش‌هایی با پشتوانه واقعی', 'minimal-maison' ),
		'testimonials_description'  => __( 'بیشتر سفارش‌های ما برای مناسبت‌های شخصی است — ازدواج، هدیه، یا ساختن چیزی که سال‌ها همراه بماند.', 'minimal-maison' ),
		'about_eyebrow'             => __( 'درباره مینیمال', 'minimal-maison' ),
		'about_heading'             => __( 'کارگاه ساخت طلا و جواهر', 'minimal-maison' ),
		'about_cta_label'           => __( 'بیشتر بدانید', 'minimal-maison' ),
		'about_cta_url'             => '/about',
		'cta_eyebrow'               => __( 'شروع گفت‌وگو با کارگاه', 'minimal-maison' ),
		'cta_heading'               => __( 'برای شروع مشاوره، چند پرسش کوتاه', 'minimal-maison' ),
		'cta_description'           => __( 'آنچه برای اولین گفت‌وگو کافی است را با ما به اشتراک بگذارید. معمولاً ظرف یک تا دو روز کاری برای هماهنگی تماس یا پیام با شما اقدام می‌کنیم.', 'minimal-maison' ),
	);
}

/**
 * Default about section paragraphs.
 *
 * @return string[]
 */
function mm_home_default_about_paragraphs(): array {
	return array(
		__( 'مینیمال یک فروشگاه آماده نیست — کارگاه ساخت طلا و جواهر است. تمرکز ما روی سفارش‌های اختصاصی است، نه تولید انبوه.', 'minimal-maison' ),
		__( 'در هر قطعه به جزئیات اهمیت می‌دهیم: انتخاب فلز، تراش سنگ، پرداخت سطح و دوام ساخت. هدف ما ساختن جواهری است که سال‌ها بتوانید با خیال راحت استفاده کنید.', 'minimal-maison' ),
		__( 'تیم ما سال‌ها در ساخت و تعمیر طلا و جواهر تجربه دارد. اگر به دنبال جایی هستید که به حرف شما گوش کند و اثر را درست بسازد، اینجا جای شماست.', 'minimal-maison' ),
	);
}

/**
 * Default process steps.
 *
 * @return array<int, array{number: string, title: string, text: string}>
 */
function mm_home_default_process_steps(): array {
	return array(
		array(
			'number' => '۰۱',
			'title'  => __( 'مشاوره', 'minimal-maison' ),
			'text'   => __( 'با گفت‌وگوی حضوری یا آنلاین شروع می‌کنیم: نوع جواهر، سنگ، بودجه و زمان تحویل را مشخص می‌کنیم.', 'minimal-maison' ),
		),
		array(
			'number' => '۰۲',
			'title'  => __( 'طراحی', 'minimal-maison' ),
			'text'   => __( 'پیش‌طرح را آماده می‌کنیم و با نظر شما اصلاح می‌کنیم تا به فرم نهایی برسیم.', 'minimal-maison' ),
		),
		array(
			'number' => '۰۳',
			'title'  => __( 'ساخت', 'minimal-maison' ),
			'text'   => __( 'ساخت در کارگاه انجام می‌شود: ریخته‌گری، پرداخت، نگین‌نشانی و کنترل کیفیت در هر مرحله.', 'minimal-maison' ),
		),
		array(
			'number' => '۰۴',
			'title'  => __( 'تحویل', 'minimal-maison' ),
			'text'   => __( 'اثر آماده تحویل است — همراه با بسته‌بندی مناسب و راهنمای نگهداری.', 'minimal-maison' ),
		),
	);
}

/**
 * Default craft process timeline steps.
 *
 * @return array<int, array{number: string, title: string, text: string}>
 */
function mm_home_default_craft_steps(): array {
	return array(
		array(
			'number' => '۰۱',
			'title'  => __( 'گفتگو', 'minimal-maison' ),
			'text'   => __( 'با یک گفت‌وگوی آرام شروع می‌کنیم — درباره سلیقه، مناسبت، بودجه و زمانی که در ذهن دارید.', 'minimal-maison' ),
		),
		array(
			'number' => '۰۲',
			'title'  => __( 'طراحی', 'minimal-maison' ),
			'text'   => __( 'پیش‌طرح اختصاصی آماده می‌شود و با نظر شما، خط به خط، به فرم نهایی می‌رسد.', 'minimal-maison' ),
		),
		array(
			'number' => '۰۳',
			'title'  => __( 'ساخت', 'minimal-maison' ),
			'text'   => __( 'در کارگاه مینیمال ساخته می‌شود — ریخته‌گری، پرداخت، نگین‌نشانی و بازبینی دقیق در هر مرحله.', 'minimal-maison' ),
		),
		array(
			'number' => '۰۴',
			'title'  => __( 'تحویل', 'minimal-maison' ),
			'text'   => __( 'اثر آماده است — همراه با بسته‌بندی مناسب و راهنمای نگهداری برای سال‌های بعد.', 'minimal-maison' ),
		),
	);
}

/**
 * Default testimonial cards.
 *
 * @return array<int, array{quote: string, author: string}>
 */
function mm_home_default_testimonials(): array {
	return array(
		array(
			'quote'  => __( '«برای حلقه ازدواجمان چیزی می‌خواستیم که فقط برای ما باشد. نتیجه دقیقاً همان چیزی شد که در ذهن داشتیم.»', 'minimal-maison' ),
			'author' => __( 'سفارش حلقه ازدواج', 'minimal-maison' ),
		),
		array(
			'quote'  => __( '«گردنبند مادرم را بازطراحی کردیم. نتیجه هم زیبا بود هم برای ما معنادار.»', 'minimal-maison' ),
			'author' => __( 'بازطراحی جواهر خانوادگی', 'minimal-maison' ),
		),
		array(
			'quote'  => __( '«در تمام مراحل در جریان بودیم و نظرمان پرسیده می‌شد. احساس کردیم کار واقعاً مال ماست.»', 'minimal-maison' ),
			'author' => __( 'سفارش گوشواره', 'minimal-maison' ),
		),
	);
}

/**
 * Default creation placeholders.
 *
 * @return array<int, array{title: string, description: string, image: string}>
 */
function mm_home_default_creation_placeholders(): array {
	return array(
		array(
			'title'       => __( 'سارا م.', 'minimal-maison' ),
			'description' => __( 'حلقه ازدواج با خوشنویسی فارسی و مروارید طبیعی — ساخته‌شده برای سالگرد ازدواج.', 'minimal-maison' ),
			'image'       => 'creation-ring',
		),
		array(
			'title'       => __( 'نرگس ک.', 'minimal-maison' ),
			'description' => __( 'گردنبند مروارید با قلاب گل الماس — هدیه‌ای که قرار بود فقط برای او باشد.', 'minimal-maison' ),
			'image'       => 'creation-necklace',
		),
		array(
			'title'       => __( 'مریم ر.', 'minimal-maison' ),
			'description' => __( 'دستبند الماس با پرداخت درخشان — طراحی‌شده بر اساس یک خاطره خانوادگی.', 'minimal-maison' ),
			'image'       => 'creation-bracelet',
		),
		array(
			'title'       => __( 'الهام س.', 'minimal-maison' ),
			'description' => __( 'گوشواره حلقه‌ای طلای زرد — فرمی مینیمال که هر روز همراهش می‌ماند.', 'minimal-maison' ),
			'image'       => 'creation-earring',
		),
		array(
			'title'       => __( 'پریسا آ.', 'minimal-maison' ),
			'description' => __( 'آویز طلا با نگین عقیق — ساخته‌شده از روی یک طرح دست‌کشیده که سال‌ها نگه داشته بود.', 'minimal-maison' ),
			'image'       => 'about',
		),
		array(
			'title'       => __( 'ندا ح.', 'minimal-maison' ),
			'description' => __( 'انگشتر نامزدی با الماس قطره‌ای — برای لحظه‌ای که فقط یک بار اتفاق می‌افتد.', 'minimal-maison' ),
			'image'       => 'atelier',
		),
	);
}
