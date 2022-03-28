<?php 
    require "../vendor/autoload.php";

    class Storage extends Aws\S3\S3Client {
        private Aws\S3\S3Client $s3;
        private string $bucket;

        public function __construct($version, $region) {
            $this -> s3 = new Aws\S3\S3Client([
                "version" => $version,
                "region" => $region
            ]);
            $this -> bucket = getenv("S3_BUCKET")?: die("Nenhuma variável de ambiente com nome 'S3_BUCKET' encontrada.");
        }

        public function put_object(string $key, $content, bool $useBody = false) {
            if ($useBody) {
                $this -> s3 -> putObject([
                    "Bucket" => $this -> bucket,
                    "Key" => $key,
                    "Body" => $content,
                ]);
            } else {
                $this -> s3 -> putObject([
                    "Bucket" => $this -> bucket,
                    "Key" => $key,
                    "SourceFile" => $content,
                ]);
            }    
        }

        public function get_object(string $key) {
            $object =  $this -> s3 -> getObject([
                "Bucket" => $this -> bucket,
                "Key" => $key
            ]);

            return $object;
        }

        public function get_objects(string $prefix) {
            $objects = $this -> s3 -> listObjectsV2([
                "Bucket" => $this -> bucket,
                "Prefix" => $prefix?: "",
            ]);
    
            if (!is_null($objects['Contents'])) {
                $first_obj = array_pop($objects['Contents']);
                array_unshift($objects['Contents'], $first_obj);
                return $objects;
            }
        }

        public function get_presigned_url(string $key) {
            $cmd = $this -> s3 -> getCommand('GetObject', [
                "Bucket" => $this -> bucket,
                "Key" => $key
            ]);
    
            $req = $this -> s3 -> createPresignedRequest($cmd, "+5 minutes");
            $url = (string) $req -> getUri();
    
            return $url;
        }

        public function delete_object(string $key) {
            $this -> s3 -> deleteObject([
                "Bucket" => $this -> bucket,
                "Key" => $key
            ]);
        }

        public function delete_objects() {
            $objects = $this -> s3 -> listObjectsV2([
                "Bucket" => $this -> bucket
            ]);
            foreach($objects['Contents'] as $object) {
                $this -> s3 -> deleteObjects([
                    "Bucket" => $this -> bucket,
                    "Delete" => [
                        "Objects" => [
                            "Key" => $object["Key"]
                        ]
                    ]
                ]);
            }
        }
    }
?>