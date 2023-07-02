import React, {useEffect, useState, useReducer} from "react";
import JobOffer from "./JobOffer";


const List  = () => {
    const [data, setData] = useState([])
    const [filters, setFilters] = useReducer(
        (state, newState) => ({...state, ...newState}),
        {
            sortBy: 'desc',
            search: '',
            days: 0,
        }
    )

    useEffect(() => {
        const url = "/api/job_offers/get_data";
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                days: filters.days,
                sortBy: filters.sortBy
            })
        };

        fetch(url, {...requestOptions})
            .then((response) => response.json())
            .then((json) => {
                setData(json)
            })
            .catch((error) => console.log(error));
    }, [filters.days, filters.sortBy]);

    const handleSortChange = (value) => {
        setFilters({
            sortBy: value

        })
    }

    const handleDaysChange = (value) => {
        setFilters({
            days: value

        })
    }

    const handleSearchChange = (value) => {
        setFilters({
            search: value

        })
    }
    return <div>
        <div>
            <input type={'text'} value={filters.search} onChange={(e) => handleSearchChange(e.target.value)}/>
            <select name="days_filter" onChange={(e) => handleDaysChange(e.target.value) }
                    value={filters.days}>
                <option value={0}>Wszystkie</option>
                <option value={1}>Z dzisiaj</option>
                <option value={3}>Z 3 dni</option>
                <option value={7}>Z 7 dni</option>
                <option value={14}>Z 14 dni</option>
                <option value={28}>Z 28 dni</option>
            </select>
            <select name="sort_filter" onChange={(e) => handleSortChange(e.target.value) }
                    value={filters.sortBy}>
                <option value={'desc'}>Od najnowszych</option>
                <option value={'asc'}>Od najstarszych</option>
            </select>
        </div>
        <div>
            {data.map((item, index) => (
                <JobOffer
                    key = {index}
                    title = {item.title}
                    description = {item.description}
                />
            ))}
        </div>

    </div>
}

export default List;