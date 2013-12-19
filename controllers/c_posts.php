<?php
	class posts_controller extends base_controller {
	
			public function __construct() {
					parent::__construct();
	
					# Make sure user is logged in if they want to use anything in this controller
					if(!$this->user) {
						
						# Send them to the login page
						Router::redirect("/users/login");
	
					}
			}
			
			public function index() {
			
				# Set up the View
				$this->template->content = View::instance('v_posts_index');
				$this->template->title   = "All Posts";
		
				# Query posts
				$q = 'SELECT 
								posts.content,
								posts.created,
								posts.user_id AS post_user_id,
								posts.post_id,
								users_users.user_id AS follower_id,
								users.first_name,
								users.last_name,
								users.profile_image
							FROM posts
								LEFT JOIN users_users ON posts.user_id = users_users.user_id_followed
								INNER JOIN users ON posts.user_id = users.user_id
							WHERE users_users.user_id = '.$this->user->user_id.' 
								OR posts.user_id = '.$this->user->user_id.'
							ORDER BY posts.created DESC';
						
				# Run posts query, store the results in the variable $posts
				$posts = DB::instance(DB_NAME)->select_rows($q);
		
				# Query comments
				$q = 'SELECT 
								comments.comment,
								comments.created,
								comments.post_id,
								users.first_name,
								users.last_name,
								users.profile_image
							FROM comments
								LEFT JOIN posts ON comments.post_id = posts.post_id
								LEFT JOIN users ON comments.user_id = users.user_id';
		
				# Run the query, store the results in the variable $comments
				$comments = DB::instance(DB_NAME)->select_rows($q);
		
				# Count of comments per post - used for styling
				$q = 'SELECT DISTINCT(post_id)
							FROM comments';
		
				# Run the query, store the results in the variable $comment_count
				$has_comment = DB::instance(DB_NAME)->select_rows($q);

				# Pass data to the View
				$this->template->content->posts = $posts;
				$this->template->content->comments = $comments;
				$this->template->content->has_comment = $has_comment;
		
				# Render the View
				echo $this->template;
			
			}
				
			public function p_add() {
	
					# Associate this post with this user
					$_POST['user_id']  = $this->user->user_id;
	
					# Unix timestamp of when this post was created / modified
					$_POST['created']  = Time::now();
					$_POST['modified'] = Time::now();
	
					# Insert to database
					DB::instance(DB_NAME)->insert('posts', $_POST);
	
					# Redirect after insert
					Router::redirect("/posts");
	
			}
			
			public function p_comment() {
	
					# Associate this comment with this user
					$_POST['user_id']  = $this->user->user_id;
	
					# Unix timestamp of when this comment was created / modified
					$_POST['created']  = Time::now();
					$_POST['modified'] = Time::now();
	
					# Insert to database
					DB::instance(DB_NAME)->insert('comments', $_POST);
	
					# Redirect after insert
					Router::redirect("/posts");
	
			}

			public function users() {
                
				# Set up view
				$this->template->content = View::instance("v_posts_users");
				
				# Set up query to get all users
				$q = 'SELECT
								user_id,
								first_name,
								last_name,
								profile_image
							FROM users
							WHERE user_ID <> '.$this->user->user_id.'
							ORDER BY first_name ASC, last_name ASC';
								
				# Run query
				$users = DB::instance(DB_NAME)->select_rows($q);
				
				# Set up query to get all connections from users_users table
				$q = 'SELECT user_id_followed
							FROM users_users
							WHERE user_id = '.$this->user->user_id;
								
				# Run query
				$connections = DB::instance(DB_NAME)->select_array($q,'user_id_followed');
				
				# Pass data to the view
				$this->template->content->users = $users;
				$this->template->content->connections = $connections;
				
				# Render view
				echo $this->template;
			
			}	
			
			public function follow($user_id_followed) {
			
					# Prepare the data array to be inserted
					$data = Array(
							"created" => Time::now(),
							"user_id" => $this->user->user_id,
							"user_id_followed" => $user_id_followed
							);
			
					# Do the insert
					DB::instance(DB_NAME)->insert('users_users', $data);
			
					# Send them back
					Router::redirect("/posts/users");
			
			}
			
			public function unfollow($user_id_followed) {
			
					# Delete this connection
					$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
					DB::instance(DB_NAME)->delete('users_users', $where_condition);
			
					# Send them back
					Router::redirect("/posts/users");
			
			}
}
	
 # end of the class