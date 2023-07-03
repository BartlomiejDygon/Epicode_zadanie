import React from "react";

const JobOffer = (props) => {

    return <div>
                <h4>{props.object.title}</h4>
                <p>{props.object.description}</p>
                <a href={window.location.origin + "/job_offer/" + props.object.id }>Aplikuj</a>
          </div>
}

export default JobOffer;