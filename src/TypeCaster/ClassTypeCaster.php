<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use Helicon\TypeConverter\Exception\TypeCasterException;
use Helicon\TypeConverter\Resolver;
use Psr\SimpleCache\CacheInterface;
use Zend\Code\Generator\DocBlock\Tag\VarTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Reflection\DocBlockReflection;
use Zend\Hydrator\ReflectionHydrator;

class ClassTypeCaster implements TypeCasterInterface
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @var ReflectionHydrator
     */
    private $reflectionHydrator;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @param Resolver           $resolver
     * @param ReflectionHydrator $reflectionHydrator
     * @param CacheInterface     $cache
     */
    public function __construct(Resolver $resolver, ReflectionHydrator $reflectionHydrator, CacheInterface $cache = null)
    {
        $this->resolver = $resolver;
        $this->reflectionHydrator = $reflectionHydrator;
        $this->cache = $cache;
    }

    /**
     * @param $value
     * @param string $type
     *
     * @return mixed|object
     *
     * @throws \ReflectionException
     */
    public function convert($value, string $type)
    {
        if (!\is_array($value)) {
            throw new TypeCasterException('ClassTypeCaster is need for array value');
        }

        $refClass = new \ReflectionClass($type);
        $schemas = $this->getSchemas($refClass);

        $results = [];
        foreach ($value as $property => $v) {
            $type = $schemas[$property];
            $results[$property] = $this->resolver->resolve($type)->convert($v, $type);
        }

        return $this->reflectionHydrator->hydrate($results, $refClass->newInstanceWithoutConstructor());
    }

    public function supports(string $type): bool
    {
        return class_exists($type);
    }

    /**
     * @param \ReflectionClass $refClass
     *
     * @return array
     */
    private function getSchemas(\ReflectionClass $refClass): array
    {
        $cached = $this->readCache($refClass->getName());
        if (null !== $cached) {
            return $cached;
        }

        $schema = [];
        foreach ($refClass->getProperties() as $property) {
            $comment = $property->getDocComment();
            $commentReflection = new DocBlockReflection($comment);
            $generator = DocBlockGenerator::fromReflection($commentReflection);
            foreach ($generator->getTags() as $tag) {
                if ($tag instanceof VarTag) {
                    $schema[$property->getName()] = $tag->getTypes()[0];
                }
            }
        }

        $this->saveCache($refClass->getName(), $schema);

        return $schema;
    }

    private function readCache(string $className): ?array
    {
        if (null === $this->cache) {
            return null;
        }

        return $this->cache->get($this->cacheKey($className));
    }

    private function saveCache(string $className, array $schema)
    {
        if (null !== $this->cache) {
            $this->cache->set($this->cacheKey($className), $schema);
        }
    }

    private function cacheKey(string $className)
    {
        return 'helicon_'.sha1($className);
    }
}
