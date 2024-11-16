<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $title;?></title>

		<meta charset="utf-8" />
		<meta name="description" content="<?php echo $this->config->item('meta_desc');?>" />
		<meta name="keywords" content="<?php echo $this->config->item('meta_keywords');?>" />
		<meta name="author" content="<?php echo $this->config->item('meta_author');?>" />

		<?php if (isset($_redirect)): echo $_redirect; endif;?>

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">

		<?php echo link_tag(MODFOLDER.'/setup/setup.css'); ?>

		<script type="text/javascript" src="//code.jquery.com/jquery-1.8.2.min.js"></script>
		<?php echo $javascript;?>
	</head>
	<body class="font-sans antialiased bg-gray-100 text-gray-500">
		<div class="max-w-5xl mx-auto">
			<header class="flex items-center justify-between py-8">
				<svg viewBox="0 0 636 170" xmlns="http://www.w3.org/2000/svg" class="h-12 w-auto">
					<g fill="none" fill-rule="evenodd">
						<path fill="#36384d" d="m297.649 145.332-76.732-68.974v68.974h-26.916V24.01h3.374l76.904 69.129V24.01h27.001v121.322zM366.142 48.864c-14.175 0-21.666 7.492-21.666 21.666v28.94c0 14.174 7.491 21.666 21.666 21.666h9.647c14.175 0 21.666-7.492 21.666-21.665V70.529c0-14.173-7.491-21.665-21.666-21.665h-9.647zm0 96.468c-30.86 0-45.863-15.001-45.863-45.861V70.529c0-30.861 15.002-45.863 45.863-45.863h9.647c30.86 0 45.862 15.001 45.862 45.864v28.94c0 30.86-15.002 45.862-45.862 45.862h-9.647zM483.241 145.332l-58.076-121.01h27.47l32.312 67.904 32.397-67.904h27.782l-58.299 121.01zM562.826 105.922h23.707L574.76 81.015l-11.934 24.907zm44.325 39.41-9.325-19.113h-46.295l-9.327 19.113H514.18l58.358-120.854h4.285l58.434 120.854h-28.105z"/>
						<path d="M169.806 5.905 127.731 47.98c2.488 4.792 1.724 10.835-2.298 14.856-4.968 4.97-13.025 4.97-17.993 0-4.969-4.969-4.969-13.025 0-17.994 4.021-4.02 10.063-4.785 14.855-2.297L164.37.47 40.962 49.778l8.374 71.161 71.161 8.374 49.31-123.408z" fill="#a133ff" />
						<path d="m120.496 129.312-71.16-8.373 58.103-58.103c4.971 4.971 13.023 4.971 17.994 0 4.021-4.02 4.786-10.06 2.294-14.856l42.078-42.077-49.309 123.41z" fill="#33adff"/>
						<path fill="#ff384f" d="m43.907 126.366 5.972 22.332L.744 169.53l20.832-49.135z"/>
						<path fill="#ffa369" d="M49.88 148.7.746 169.528l43.162-43.163z"/>
					</g>
				</svg>

				<div class="flex items-center gap-x-2 text-xl/7 tracking-tight">
					<span class="font-normal">Setup Center</span>
					<span class="font-bold text-white rounded-lg py-1 px-2 bg-[#a133ff]">Update Nova</span>
				</div>
			</header>

			<div class="bg-white rounded-xl overflow-hidden ring-1 ring-gray-950/5 shadow-xl">
				<div class="p-8 space-y-8">
					<h1 class="text-gray-950 tracking-tight text-4xl font-extrabold"><?php echo $label;?></h1>

					<div class="text-base/7">
						<div id="loading" class="hidden flex items-center">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="-ms-1 me-2 animate-spin size-7 text-gray-400" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg>

							<strong class="text-lg">Processing, please wait...</strong>
						</div>

						<div id="loaded">
							<?php echo $flash_message;?>

							<?php echo $content;?>
						</div>
					</div>

					<?php if ($controls !== false): ?>
						<div class="lower">
							<div class="control"><?php echo $controls;?></div>
						</div>
					<?php endif;?>
				</div>

				<?php if ($lowerWarning !== false): ?>
					<div class="flex gap-x-2.5 py-4 px-8 bg-warning-50 border-t border-warning-200 text-warning-600 text-sm/6">
						<svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 stroke-warning-700 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>

						<p><?php echo $lowerWarning;?></p>
					</div>
				<?php endif;?>

				<?php if ($lowerDanger !== false): ?>
					<div class="flex gap-x-2.5 py-4 px-8 bg-danger-50 border-t border-danger-200 text-danger-600 text-sm/6">
						<svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 stroke-danger-700 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>

						<p><?php echo $lowerDanger;?></p>
					</div>
				<?php endif;?>
			</div>

			<div class="text-center py-4 text-sm/6 text-gray-400">
				Built with &#9829; by <a href="https://anodyne-productions.com" target="_blank" class="underline">Anodyne</a>
			</div>
		</div>
	</body>
</html>