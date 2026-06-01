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
		'creations_eyebrow'         => __( 'نمونه کارها', 'minimal-maison' ),
		'creations_heading'         => __( 'برخی از سفارش‌های اخیر', 'minimal-maison' ),
		'creations_description'     => __( 'این‌ها نمونه‌ای از کارهایی است که برای مشتریان ساخته‌ایم. هر قطعه بر اساس درخواست همان شخص طراحی شده است.', 'minimal-maison' ),
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
 * Default testimonial cards.
 *
 * @return array<int, array{quote: string, author: string}>
 */
function mm_home_default_testimonials(): array {
	return array(
		array(
			'quote'  => __( '«برای حلقه ازدواجمان می‌خواستیم چیزی ساده و ماندگار باشد. مینیمال دقیقاً همان چیزی را ساخت که در ذهنمان بود.»', 'minimal-maison' ),
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
 * @return array<int, array{subtitle: string, title: string, price: string, image: string}>
 */
function mm_home_default_creation_placeholders(): array {
	return array(
		array(
			'subtitle' => __( 'انگشتر سفارشی', 'minimal-maison' ),
			'title'    => __( 'مدل لینا', 'minimal-maison' ),
			'price'    => __( 'قیمت پس از مشاوره', 'minimal-maison' ),
			'image'    => 'creation-ring',
		),
		array(
			'subtitle' => __( 'گردنبند', 'minimal-maison' ),
			'title'    => __( 'مدل آرک', 'minimal-maison' ),
			'price'    => __( 'قیمت پس از مشاوره', 'minimal-maison' ),
			'image'    => 'creation-necklace',
		),
		array(
			'subtitle' => __( 'دستبند', 'minimal-maison' ),
			'title'    => __( 'مدل باران', 'minimal-maison' ),
			'price'    => __( 'قیمت پس از مشاوره', 'minimal-maison' ),
			'image'    => 'creation-bracelet',
		),
		array(
			'subtitle' => __( 'گوشواره', 'minimal-maison' ),
			'title'    => __( 'مدل دون', 'minimal-maison' ),
			'price'    => __( 'قیمت پس از مشاوره', 'minimal-maison' ),
			'image'    => 'creation-earring',
		),
	);
}
