import axios from "axios"

//The js class/functions that trigger the heart/like emoji on the professor pages
class Like {
  constructor() {
    if (document.querySelector(".like-box")) {
        //We want to declare the nonce globally so we dont have to declare it everytime
      axios.defaults.headers.common["X-WP-Nonce"] = universityData.nonce
      this.events() //so that our events are automatically created when this class is called
    }
  }

  //adds the event where the click button on the like box will trigger the said events
  events() {
    document.querySelector(".like-box").addEventListener("click", e => this.ourClickDispatcher(e))
  }

  // methods
      //Checks if our click button on the heart emoji is triggered
  ourClickDispatcher(e) {
      //This closest function will test to find the closest ancestor of the html/js code so that even 
    //if they click the heart, the box will be triggered
    let currentLikeBox = e.target
    while (!currentLikeBox.classList.contains("like-box")) {
      currentLikeBox = currentLikeBox.parentElement
    }
    //please note that the currentlikebox element .like-box is taken from the class of the single-professor.php page
    //<span class="like-box" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $existStatus; ?>">

    //checks the currentlikebox value of the data exists (which can be changed from the creatLike and deleteLike functions)
    if (currentLikeBox.getAttribute("data-exists") == "yes") {
      this.deleteLike(currentLikeBox)
    } else {
      this.createLike(currentLikeBox)
    }
  }

  //Creates the createLike function to fill in the heart emoji and post a link post to the database
  async createLike(currentLikeBox) {
    try {
        //The database being entered si from the url root + the route + the professor Id that we want to like
      const response = await axios.post(universityData.root_url + "/wp-json/university/v1/manageLike", { "professorId": currentLikeBox.getAttribute("data-professor") })
      if (response.data != "Only logged in users can create a like.") {
        //We set the attribute data-exists from the single-professor php file
        currentLikeBox.setAttribute("data-exists", "yes")
        // parse the integers by 10 for the total like counts
        var likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10)
        likeCount++ //we increase the like count by one
        //we need to display the like count next to the heart emoji
        currentLikeBox.querySelector(".like-count").innerHTML = likeCount
        //we need to make trigger the animation effect when the data is being triggered
        currentLikeBox.setAttribute("data-like", response.data)
      }
      console.log(response.data)
    } catch (e) {
      console.log("Sorry") //otherwise return an error message
    }
  }

  //to remove a like that we already liked on a professor page
  async deleteLike(currentLikeBox) {
    try {
      const response = await axios({
          //we only need to find the root url + the route to find the data that we need to delete
        url: universityData.root_url + "/wp-json/university/v1/manageLike",
        method: 'delete',
        //we need to get the data from the database: data-like
        data: { "like": currentLikeBox.getAttribute("data-like") },
      })
      //we need to ste the data-exists attriute to no since the like will now be removed 
      currentLikeBox.setAttribute("data-exists", "no")
      // parse the integers by 10 for the total like counts
      var likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10)
      likeCount--
      currentLikeBox.querySelector(".like-count").innerHTML = likeCount
      currentLikeBox.setAttribute("data-like", "")
      console.log(response.data)
    } catch (e) {
      console.log(e)
    }
  }
}

export default Like