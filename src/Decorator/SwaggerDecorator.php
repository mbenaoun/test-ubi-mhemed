<?php

namespace App\Decorator;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SwaggerDecorator.
 */
final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $customDefinition = [
            'name' => 'fields',
            'description' => 'Fields to remove of the output',
            'default' => 'id',
            'in' => 'query',
        ];

        // e.g. add a custom parameter
        $docs['paths']['/foos']['get']['parameters'][] = $customDefinition;

        // Override title
        $docs['info']['title'] = 'Test UBI Mhemed';

        return $docs;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
