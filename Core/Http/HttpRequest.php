<?php
	
namespace Core\Http;


use Core\Entities\ErrorCodes;
use Core\Http\Enums\ContentTypes;
use Core\Http\Enums\RequestTypes;
use Core\Options\IApplicationOption;
use stdClass;

/**
 * Class HttpRequest
 * @package Core\Http
 */
class HttpRequest
{
	#region Public Fields
	/**
     * @var string
     */
    public string $Type = "";

    /**
     * @var HttpHeaders
     */
    public HttpHeaders $Header;

    /**
     * @var object
     */
    public object $Body;

    #endregion
    
    #region Private Fields
    private IApplicationOption $_applicationOption;
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    /**
     * @param string $methodType
     * @param IApplicationOption $applicationOption
     */
    public function __construct(string $methodType, IApplicationOption $applicationOption)
	{
	    $this->_applicationOption = $applicationOption;

        if (!empty($_FILES)) {
            $this->CheckUploadFileSizes();
        }

        $this->Header = new HttpHeaders();
        $this->Type = $methodType;

        if($this->Type == RequestTypes::$Get)
            $this->Body = (object)$_GET;

        if($this->Type == RequestTypes::$Post)
            $this->Body = $this->Post();
	}
    #endregion
    
    #region Private Methods
    private function CheckUploadFileSizes() {
        $fileErrorMessages = [];
        foreach ($_FILES as $file) {
            if ($file["size"] > $this->_applicationOption->UploadSize() * 1024 * 1024){
                array_push($fileErrorMessages, $file["name"] . " is bigger then " . $this->_applicationOption->UploadSize());
            }
        }

        if(count($fileErrorMessages) === 0)
            HttpResponse::Error(implode(",", $fileErrorMessages), ErrorCodes::$FileSizeExceeded);
    }

    private function Post() {
        switch ( $this->Header->ContentType ) {
            case ContentTypes::$Json:
            {
                $json = file_get_contents( 'php://input' );
                if (!isset($json) || empty($json) || $json === ""){
                    return new stdClass();
                } else {
                    return json_decode( $json, false, 512, JSON_NUMERIC_CHECK);
                }
            }
            case ContentTypes::$XFormUrlEncoded:
            case ContentTypes::$MultipartFormData:
            default:
                {
                return (object)$_POST;
            }
        }
    }
    #endregion
    
    #region Helpers
    #endregion
}
