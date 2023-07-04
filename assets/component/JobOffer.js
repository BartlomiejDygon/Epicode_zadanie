import React from "react";

const JobOffer = (props) => {
    var date = new Date(props.object.createdAt.date);

    return <div className={'ten list_tile flex_row'}>
                <div className={'six float-left  list_tile_content '}>
                    <div className={'float-left four box'}>
                        <h2>{props.object.title}</h2>
                        <p>Opublikowano: {date.getDay()}/{date.getMonth()}/{date.getFullYear()}</p>
                    </div>
                    <p className={'box six list_tile_description'}>{props.object.description}</p>
                </div>
                <a className={'float_right apply_button'} href={window.location.origin + "/job_offer/show/" + props.object.id }>Otwórz</a>
          </div>
}

export default JobOffer;