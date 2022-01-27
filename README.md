# FoBV - WordPress

David Williamson @ Varilink Computing Ltd

------

This is the repository for The Friends of Bennerley Viaduct (FoBV) website,
which is based on WordPress. It contains:
1. The website's WordPress theme.
2. My [WordPress plugins](https://github.com/varilink/libraries-wordpress_plugins) library as a submodule.
3. Migrations for the website.

The plugins submodule enables development and testing of any of those plugins
that this website uses within the client environment created by my
[FoBV - Docker](https://github.com/varilink/fobv-docker) repository. In other
words, in the context of their use by this website. It tracks the correlation of
versions of this website to versions of my plugin library.

The migrations are inspired by the concept of migrations in the Django web
framework. They contain updates to the content of the website accompany theme
changes. These would normally be applied manually, in the WordPress dashboard
but I have attempted to define them as WP CLI commands so that their deployment
alongside the theme changes that they accompany can be automated using Ansible,
see my [FoBV - Ansible](https://github.com/varilink/fobv-ansible) repository.
