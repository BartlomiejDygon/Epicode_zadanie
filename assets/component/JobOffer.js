import React from "react";

const JobOffer = (props) => {

    return <div>
        <h4>{props.title}</h4>
        <p>{props.description}</p>
        <a href={window.location.origin + "/dupixent-contest-test"}>Aplikuj</a>
    </div>
}

export default JobOffer;