# SMF Highslide Image Viewer mod
* **Author:** digger http://mysmf.ru
* **License:** The MIT License (MIT)
* **Compatible with:** SMF 2.0

## Description
* Show full-size image like popup window when user click thumbnail
* Autoresize full-size image for browser window
* Slideshow for images on page
* Prev/Next with arrow keys
* Work for attached and linked images with thumbnails
* Also works for thumbnails from Imageshack.us, Photobucket.com, iPicture.ru, Radikal.ru, Keep4u.ru, Xs.to and Fotosik.pl

What is Highslide JS?

Highslide JS is an open source JavaScript software, offering a Web 2.0 approach to popup windows. It streamlines the use of thumbnail images and HTML popups on web pages. The library offers these features and advantages: 
* No plugins like Flash or Java required.
* Popup blockers are no problem. The content expands within the active browser window.
* Single click. After opening the image or HTML popup, the user can scroll further down or leave  the page without closing it.
* Compatibility and safe fallback. If the user has disabled JavaScript or is using an old browser, the browser redirects directly to the image itself or to a fallback HTML page.
* http://highslide.com

## Описание
* При клике на картинку подгружается большое изображение. Если оно больше области просмотра, то сжимается до границ области просмотра и появляется значок при клике на который растягивается до оригинального размера. Изображение можно перетаскивать. При повторном клике большое изображение "возвращается на место".
* Стрелки курсора на клавиатуре листают все изображения на странице. Имеется функция слайдшоу для картинок размещенных в пределах одной страницы.
* Если в сообщении есть превью картинки с сервисов Imageshack.us, Photobucket.com, iPicture.ru, Radikal.ru, Keep4u.ru, Xs.to или Fotosik.pl, то отработает подгрузка оригинала. Также, если вы разместите картинку внутри ссылки на полную картинку, то она будет обработана.

История:
* 1.0 beta2. Добавления и поддержка iPicture.ru (deadbead).
* 1.0 beta3. Исправлена обработка ссылок типа [url=http://site.com][ img ]...[/img][ /url ]
* 1.0 beta4. Исправлена обработка недоисправленная в beta3. Добавлено отображение элементов навигации на изображении.
* 1.0 RC1. Добавлена функция слайдшоу в пределах страницы. Мелкие исправления.
* 1.0 RC2. Мелкие косметические исправления.
* 1.0 RC3. Добавлена совместимость с SMF2.
* 1.0 RC4. Добавлена поддержка языковых файлов. Добавлены языки: russian и russian-utf8.
* 1.0 RC5. Добавлен датский язык.
* 1.0 RC6. Мелкие косметические исправления. При слайдшоу/листании картинок эффект смены изображений изменен на более подходящий.
* 1.0 RC7 - Исправлена ошибка "Undefined index:  subject" возникающая при работе с некоторыми бриджами/порталами. Добавлен французский язык.
* 1.0 RC8 - Исправлена ошибка "Undefined index:  host" возникающая из-за неправильных путей у вложений..
* 1.0 RC9 - Добавлена поддержка превьюшек из SMF Media Gallery.
Обратываются BBC вроде таких:
[img]http://smf-media.com/community/MGalleryItem.php?id=167;preview[/img][
[img]http://smf-media.com/community/MGalleryItem.php?id=167;thumb[/img]
* 1.0 Devel - Добавлена поддержка Radikal.ru (deadbead) и keep4u.ru
* 1.1 Мелкие исправления. Убрана поддержка SMF Media Gallery из за несовместимости 
* модов. Добавлена поддержка Xs.to (jamz).
* 1.2 Исправлена обработка [url=some_link][img] photohosting_thumbnail [/img][/url]
* 1.3 Исправлена обработка изображений в подписях.                                                                                                       
* 1.4 Добавлена поддержка мода Attachments In Message для SMF1.x
* 1.5 Добавлена поддержка мода Attachments In Message
* 1.6 Добавлена поддержка SMF2 RC2
* 1.7 Добавлена поддержка SMF2.0. SMF1 больше не поддерживается.
* 1.8 Незначительные улучшения