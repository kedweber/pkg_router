# Pkg_router## DescriptionStock Joomla! routing is primitive at best. Moyo basically took the [Symfony 2 router](https://github.com/symfony/Routing) and ported it to Joomla using theNooku / Koowa framework.Pkg_router was created by [Moyo Web Architects](http://moyoweb.nl) and is currently used in several major projects.## Requirements* Joomla 3.X . Untested in Joomla 2.5.* Koowa 0.9 or 1.0 (as yet, Koowa 2 is not supported)* PHP 5.3.10 or better## InstallationInstallation is done through composer. In your `composer.json` file, you should add the following lines to the repositoriessection:```json{    "name": "moyo/router",    "type": "vcs",    "url": "https://github.com/cta-int/router.git"}```The require section should contain the following lines:```json    "moyo/router": "3.0.*"```Afterward, just run `composer update` from the root of your Joomla project.### jsymlinkerAnother option, currently only available for Moyo developers, is by using the jsymlink script from the [Moyo GitTools](https://github.com/derjoachim/moyo-git-tools).### UsageA `routing.yml` is required at the following location: administrator/config/com_routes/routing.yml. Also see: http://symfony.com/doc/current/book/routing.htmlMake sure to provide the defaults option and view.## ExampleLet's take our own Article package for example. The standard URLs for articles are as follow: `index.php?option=com_article&view=article&id=1`.Now if we want a pretty URL for that we need to add it to the routing.yml file:```yamlarticle:    path: '/{_locale}/article/{slug}.{format}'    defaults:        option: com_articles        view: article    requirements: null```