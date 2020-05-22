<?php
	
	
namespace Core\Http;


/**
 * Class HttpHeaders
 * @package Core\Http
 */
class HttpHeaders
{
	#region Public Fields
    /**
     * @var string
     */
    public string $ContentType = '';

    /**
     * @var mixed|string
     */
    public string $UserAgent = '';

    /**
     * @var mixed|string
     */
    public string $Accept = '';

    /**
     * @var mixed|string
     */
    public string $CacheControl = '';

    /**
     * @var mixed|string
     */
    public string $Host = '';

    /**
     * @var mixed|string
     */
    public string $AcceptEncoding = '';

    /**
     * @var mixed|string
     */
    public string $ContentLength = '';

    /**
     * @var mixed|string
     */
    public string $Cookie = '';

    /**
     * @var mixed|string
     */
    public string $Connection = '';

    /**
     * @var array|false|null
     */
    public $Rest;

    /**
     * @var bool
     */
    public bool $IsEmpty = true;
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    /**
     * HttpHeaders constructor.
     */
    public function __construct()
	{
		$this->ParseHeader(getallheaders());
	}

	private function ParseHeader($headers){
        if ( isset($headers)  ) {
            $this->IsEmpty = false;
        }

        if ( isset( $headers[ 'Content-Type' ] ) ){
            $this->ContentType = $headers[ 'Content-Type' ];
            if (strstr($headers[ 'Content-Type' ], "multipart/form-data") !== false){
                $this->ContentType = "multipart/form-data";
            }
        }
        if ( isset( $headers[ 'Content-Length' ] ) )
            $this->ContentLength = $headers[ 'Content-Length' ];
        if ( isset( $headers[ 'User-Agent' ] ) )
            $this->UserAgent = $headers[ 'User-Agent' ];
        if ( isset( $headers[ 'Accept' ] ) )
            $this->Accept = $headers[ 'Accept' ];
        if ( isset( $headers[ 'Accept-Encoding' ] ) )
            $this->AcceptEncoding = $headers[ 'Accept-Encoding' ];
        if ( isset( $headers[ 'Cache-Control' ] ) )
            $this->CacheControl = $headers[ 'Cache-Control' ];
        if ( isset( $headers[ 'Connection' ] ) )
            $this->Connection = $headers[ 'Connection' ];
        if ( isset( $headers[ 'Cookie' ] ) )
            $this->Cookie = $headers[ 'Cookie' ];
        if ( isset( $headers[ 'Host' ] ) )
            $this->Host = $headers[ 'Host' ];

        $this->Rest = $headers;
    }
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
	
	
	
}
