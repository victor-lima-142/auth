import React, { useState } from 'react';
import Carousel from 'react-bootstrap/Carousel';
import "./banner.scss"

const Banner = (props: any): JSX.Element => {
    const [index, setIndex] = useState(0);
    const handleSelect = (selectedIndex: number, e: any): void => setIndex(selectedIndex);

    return (
        <Carousel activeIndex={index} onSelect={handleSelect}>
            <Carousel.Item>
                <img className="banner-img" src="https://images.ctfassets.net/23aumh6u8s0i/3Cu6Hhk4uxBk10a168mv7g/b7d9b0fcd37582dd087327574361ff8b/WhatIs_Broken_Auth_sep-2" alt="First slide" />
                <Carousel.Caption>
                    <h3>First slide label</h3>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </Carousel.Caption>
            </Carousel.Item>
            <Carousel.Item>
                <img className="banner-img" src="https://images4.alphacoders.com/110/1108171.png" alt="Second slide" />
                <Carousel.Caption>
                    <h3>Second slide label</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </Carousel.Caption>
            </Carousel.Item>
            <Carousel.Item>
                <img className="banner-img" src="https://wallpapers.com/images/hd/top-view-graphic-hacker-4k-desk-upgzrk1vtwd064b6.jpg" alt="Third slide" />
                <Carousel.Caption>
                    <h3>Third slide label</h3>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                </Carousel.Caption>
            </Carousel.Item>
        </Carousel>
    );
}

export default Banner;