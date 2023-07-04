import React, {useEffect, useState, useReducer} from "react";
import JobOffer from "./JobOffer";
import ReactPaginate from 'react-paginate'

const List  = () => {
    const [data, setData] = useState([])
    const [filteredData, setFilteredData] = useState([])
    const [itemPerPage] = useState(10)
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

    useEffect(() => {
        const filteredItems = filterItems(data);
        setFilteredData(filteredItems);
    }, [filters.search, data]);


    const filterItems = (itemsToFilter) => {
        var filteredItems = itemsToFilter;
        if (filters.search !== '') {
            filteredItems = filteredItems.filter(item => {
                return item.title.toLowerCase().includes(filters.search.toLowerCase());
            })
        }

        return filteredItems;
    }
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

    function Items({ currentItems }) {
        return (
            <>
                {currentItems &&
                    currentItems.map((item, index) => (
                        <JobOffer
                            key = {index}
                            object = {item}
                        />
                    )
                )}
            </>
        );
    }

    function PaginatedItems({ itemsPerPage }) {

        const [itemOffset, setItemOffset] = useState(0);
        const endOffset = itemOffset + itemsPerPage;
        const currentItems = filteredData.slice(itemOffset, endOffset);
        const pageCount = Math.ceil(filteredData.length / itemsPerPage);

        const handlePageClick = (event) => {
            const newOffset = (event.selected * itemsPerPage) % filteredData.length;
            setItemOffset(newOffset);
        };

        return (
            <div className={'ten flex_column job_offer_list_content_container'}>
                <div className={'job_offer_list flex_column'}>
                    <Items currentItems={currentItems} />
                </div>
                <div className={'job_offer_list_pagination four'}>
                    <ReactPaginate
                        breakLabel="..."
                        nextLabel="następne >"
                        onPageChange={handlePageClick}
                        pageRangeDisplayed={5}
                        pageCount={pageCount}
                        previousLabel="< poprzednie"
                        renderOnZeroPageCount={null}
                    />
                </div>
            </div>
        );
    }


    return <div className={'ten flex_column job_offer_list_container'}>
        <div className={'job_offer_filters six'}>
            <input className={'six'}
                   type={'text'}
                   value={filters.search}
                   onChange={(e) => handleSearchChange(e.target.value)}
                   placeholder={'Wyszukaj'}
            />
            <select className={'two'} name="days_filter" onChange={(e) => handleDaysChange(e.target.value) }
                    value={filters.days}>
                <option value={0}>Wszystkie</option>
                <option value={1}>Z dzisiaj</option>
                <option value={3}>Z 3 dni</option>
                <option value={7}>Z 7 dni</option>
                <option value={14}>Z 14 dni</option>
                <option value={28}>Z 28 dni</option>
            </select>
            <select className={'two'} name="sort_filter" onChange={(e) => handleSortChange(e.target.value) }
                    value={filters.sortBy}>
                <option value={'desc'}>Od najnowszych</option>
                <option value={'asc'}>Od najstarszych</option>
            </select>
        </div>
            <PaginatedItems itemsPerPage={itemPerPage} />
    </div>
}

export default List;