<?php

	namespace Core;
	
	
    use Core\Http\HttpRequest;

    /**
	 * Class Controller
	 * @package Core
	 */
	class Controller
	{
	    #region Public Fields

        /**
         * Request object that holds Header Information, Request Type, Request Body (Post or Get)
         * and Parameters on URI which slitted by "\"
         * @var HttpRequest
         */
        protected HttpRequest $Request;

        /**
         * @var array
         */
        protected array $Params;
	    #endregion
	
	    #region Private Fields
	    #endregion
	
	    #region Public Methods
	    #endregion
	
	    #region Constructor
        /**
         * Controller constructor.
         * @param HttpRequest $request
         * @param array $params
         */
	    public function __construct(HttpRequest $request, array $params)
	    {
	        $this->Request = $request;
	        $this->Params = $params;
	    }
	    #endregion
	
	    #region Private Methods
	    #endregion
	
	    #region Helpers
	    #endregion
	}
