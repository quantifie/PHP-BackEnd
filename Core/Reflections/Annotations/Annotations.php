<?php


namespace Core\Reflections\Annotations;

/**
 * Class Annotations
 * @package Core\Reflections\Annotations
 */
class Annotations
{
    /**
     * @var string
     */
    private static string $_prefix = "|@";
    /**
     * @var string
     */
    private static string $_suffix = "";

    /**
     * @var string
     */
    private static string $_keyValueSplitChar = "=";

    /**
     * @var string
     */
    private static string $_docSuffix = "*/";

    /**
     * @var string
     */
    private static string $_docPrefix = "/**";

    /**
     * @var string
     */
    private static string $_docDelimiter = "*";

    /**
     * Annotations constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param string $documentString
     * @return array
     */
    private function DocToArray(string $documentString): array {
        $doc = ltrim($documentString, self::$_docPrefix);
        $doc = rtrim($doc, self::$_docSuffix);
        return explode(self::$_docDelimiter, $doc);
    }

    /**
     * @param string $documentString
     * @return AnnotationModel[]
     */
    public function Get(string $documentString): array {
        $docLines = self::DocToArray($documentString);

        $possibleAnnotations = [];

        foreach ($docLines as $docLine) {
            $docLine = trim($docLine);
            $decorationPosition = strpos($docLine, self::$_prefix);
            if($decorationPosition !== false) {
                $annotationString = strstr($docLine, self::$_prefix);
                $annotationString = ltrim($annotationString, self::$_prefix);
                $annotationString = rtrim($annotationString,self::$_suffix);
                $annotationKeyValue = explode(self::$_keyValueSplitChar, $annotationString);
                $newAnnotation = new AnnotationModel();
                $newAnnotation->Name = trim($annotationKeyValue[0]);
                $newAnnotation->Value = trim($annotationKeyValue[1]);
                array_push($possibleAnnotations, $newAnnotation);
            }
        }

        return $possibleAnnotations;
    }
    #endregion

    #region Helpers
    #endregion
}
