<?php
	
	namespace Core\Http\Enums;

    /**
     * Class ContentTypes
     * @package Core\Http\Enums
     */
    abstract class ContentTypes
	{
		public static string $Json = "application/json";
		public static string $Xml = "application/xml";
		public static string $Javascript = "application/javascript";
		public static string $Pdf = "application/pdf";
		public static string $Zip = "application/zip";
		public static string $XFormUrlEncoded = "application/x-www-form-urlencoded";
		public static string $MultipartMixed = "multipart/mixed";
		public static string $MultipartAlternative = "multipart/alternative";
		public static string $MultipartFormData = "multipart/form-data";
	}
