<?php

    class Category {

        private $con, $username;

        public function __construct($con, $username) {
            $this->con = $con;
            $this->username = $username;
            $this->url = new URL($con);
			$this->slide = new Slide($con, $username);
			$this->use = new Functions($con, $username);
        }

        public function getCategory($data, $limit) {

			$page = $data['page'];
			$categoryId = $data['categoryId'];

			if($page == 1) 
				$start = 0;
			else 
				$start = ($page - 1) * $limit;

			$str = ""; //String to return 
			$Q = mysqli_query($this->con, "SELECT * FROM video WHERE categoryId='$categoryId' GROUP BY entityId");

			if(mysqli_num_rows($Q) > 0) {

				$num_iterations = 0; //Number of results checked (not necasserily posted)
				$count = 1;

				while($R = mysqli_fetch_array($Q)) {

					$id = $R['id'];

					if($num_iterations++ < $start)
						continue; 

					//Once 10 videos have been loaded, break
					if($count > $limit) {
						break;
					}
					else {
						$count++;
					}

					$str .= $this->slide->getSlide($id, $R['isMovie'], NULL, 'src', NULL);

				} //End while loop

				if($count > $limit) 
					$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
								<input type='hidden' class='noMorePosts' value='false'>";
				else{
					$str .= "<input type='hidden' class='noMorePosts' value='true'>
                            <div class='loadingAjaxEndContainer'>
                                <div class='loadingAjaxEnd'>
                                    <i class='fa-solid fa-circle-check loadingAjaxiIcon'></i>
                                    <div class='loadingAjaxText'>To już wszystko</div>
                                </div>
                            </div>";
				}
			}

			echo $str;



        }


    }

?>