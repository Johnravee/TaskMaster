import React from "react";
import '../css/About.css'
import avila from '../assets/images/avila.jpeg'
import lee from '../assets/images/lee.jpeg'
import jomel from '../assets/images/jomel.jpeg'
import regillas from '../assets/images/regillas.jpeg'
import bravo from '../assets/images/BRAVO.png'
import MAX from '../assets/images/MAX.jpg'
import NELVIC from '../assets/images/NELVIC.jpg'
import pogi from '../assets/images/pogi.jpeg'
import pogi2 from '../assets/images/pogi2.jpeg'
import pogi3 from '../assets/images/pogi3.jpeg'
const members = [
  { id: 1, name: "Avila Kenneth Ivan M", role: "Frontend Developer", skills: "React, JavaScript, CSS", image: avila },
  { id: 2, name: "Bravo Rene Boy S", role: "FrontEnd Developer", skills: "Node.js, Express, MongoDB", image: bravo},
  { id: 3, name: "Regilisa Lovely C", role: "Documentation", skills: "Figma, Sketch, Adobe XD", image:  regillas },
  { id: 4, name: "Mimay John Rave N", role: "BackEnd Developer", skills: "MongDb, php, Node.js", image:  pogi },
  { id: 5, name: "Arcilla John Lee B", role: "BackEnd Developer", skills: "Pro Dancer", image:  lee },
  { id: 6, name: "Mariño jomel M", role: "FrontEnd Developer", skills: "Best Chef", image:  jomel },
  { id: 7, name: "Tibay John Anthony", role: "Documentation", skills: "Flutter, Swift, Kotlin", image:  pogi2 },
  { id: 8, name: "Sevial Nelvic S", role: "Documentation", skills: "Photoshop, Illustrator, InDesign", image:  NELVIC },
  { id: 9, name: "Hormillosa Mhaxine A", role: "Documentation", skills: "MERN Stack, TypeScript, GraphQL", image:  MAX},
  { id: 10, name: "Noronio charles kenjie", role: "Documentation", skills: "Machine Learning, OpenAI, R", image: pogi3 },
];


const AboutUs = () => {
  return (
      <div className="about-us">
        <h2>About Us</h2>
        <p>
        Welcome to Task Master, your ultimate solution for organizing, prioritizing, and achieving your goals. 
        Our mission is to simplify task management and help individuals and teams stay productive in an ever-busy world.
        We are a passionate team of developers, designers, and productivity interested committed to transforming how people manage their time and tasks. With a deep understanding of the challenges of modern work,
         we’ve designed a platform that puts simplicity, efficiency, and collaboration at the forefront.
        </p>

        <div className="members">
          {members.map((member) => (
            <div key={member.id} className="member-card">
              <div className="member-info">
                <div className="image-wrapper">
                  <img src={member.image} alt={member.name} className="member-image" />
                  <div className="hover-overlay">
                    <p>{member.role}</p>
                    <p>{member.skills}</p>
                  </div>
                </div>
                <h3>{member.name}</h3>
              </div>
            </div>
          ))}
        </div>
      </div>
  );
};

export default AboutUs;