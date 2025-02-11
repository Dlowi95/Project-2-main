<?php
namespace Aws\ChimeSDKMediaPipelines;

use Aws\AwsClient;

/**
 * This client is used to interact with the **Amazon Chime SDK Media Pipelines** service.
 * @method \Aws\Result createMediaCapturePipeline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createMediaCapturePipelineAsync(array $args = [])
 * @method \Aws\Result createMediaConcatenationPipeline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createMediaConcatenationPipelineAsync(array $args = [])
 * @method \Aws\Result createMediaLiveConnectorPipeline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createMediaLiveConnectorPipelineAsync(array $args = [])
 * @method \Aws\Result deleteMediaCapturePipeline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteMediaCapturePipelineAsync(array $args = [])
 * @method \Aws\Result deleteMediaPipeline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteMediaPipelineAsync(array $args = [])
 * @method \Aws\Result getMediaCapturePipeline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMediaCapturePipelineAsync(array $args = [])
 * @method \Aws\Result getMediaPipeline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMediaPipelineAsync(array $args = [])
 * @method \Aws\Result listMediaCapturePipelines(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMediaCapturePipelinesAsync(array $args = [])
 * @method \Aws\Result listMediaPipelines(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMediaPipelinesAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result tagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \Aws\Result untagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 */
class ChimeSDKMediaPipelinesClient extends AwsClient {}
