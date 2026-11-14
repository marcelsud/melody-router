# Melody Router

**Deprecated and no longer maintained.** This standalone PHP router is preserved as historical source. Existing Composer versions, tags and the master/develop branches remain available.

The project originated with PHP 5.3/5.4 verification and PSR-0 autoloading. Current PHP compatibility is not certified. There is no further feature or maintenance roadmap.

## Migrate existing applications

For new code, evaluate the [Symfony Routing component](https://symfony.com/doc/current/components/routing.html), which can be used without the full Symfony framework.

Migration requires adapting the application's route definitions, parameter requirements, matching results and failure handling. Symfony Routing is not a drop-in replacement for Melody Router's Route/Router interfaces or custom definition rules.

Before changing dependencies:

1. Inventory route names, patterns and custom validation rules in your application.
2. Record expected matches, extracted inputs and non-matches in consumer tests.
3. Implement those routes with your chosen router and compare results, including invalid paths.
4. Switch the application boundary and remove Melody Router only after those checks pass.

Composer package `marcelsud/melody-router` remains available for existing consumers. Deprecation does not remove installed versions or rewrite either development branch's earlier commits.

## License

See [LICENCE](LICENCE).