# mywordpress-cdn
wordpress 加速CDN插件

网上已有的CDN插件，有的除了CDN功能之外，再加一堆其它“优化”功能，有的加点自己的小广告，感觉很不爽，于是有了此插件。

1. 它是一个纯粹的CDN插件，没有别的功能。

2. 它是一个绿色的插件，不会在你的数据库内留下任何参数，不想用了，删除它后，不会留下任何“遗迹”。

3. 你唯一要做的是：看一下代码，指定你的CDN加速域名。

如有问题，欢迎联系QQ：57620133 或到 mywordpress.cn网站留言

-------------------------------------------------------------

什么是镜像?

打个比如。A网站很快，你的网站(mysite.com)很慢，于是你想能不能图片放到A上去，于是你做了一个二级域名cdn.mysite.com指向A(通过cname)
然后手工把图片传到A网站上, 这样用户访问cdn.mysite.com时就访问到A网站上了。

可是你的网站上总是会有新的图片，每次要上传很麻烦，要是A在找不到图片时能到你的网站抓一下多好，还真有这功能，即在A网站上设置回源。
于是，A看起像是你的网站的一个镜像。