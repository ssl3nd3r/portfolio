import React , {useRef , useState} from 'react'
import Typewriter from 'typewriter-effect';


export default function Info({info}) {
  const [skill, setSkill] = useState(false)
  const theme = useRef()
  const skillName = useRef()
  const darkMode = () => {
    return e => {
      if (document.body.classList.contains('dark')) {
        document.body.classList.remove('dark')
        theme.current.src = '/storage/moon.svg';
      }
      else {
        document.body.classList.add('dark')
        theme.current.src = '/storage/sun.svg';
      }
    }
  }

  const displaySkill = () => {
    return e => {
      setSkill(true);
      skillName.current.innerText = e.target.alt;
    }
  }
  return (
    <div className='lg:fixed lg:h-screen flex flex-col gap-8 justify-between p-8 lg:px-20 lg:py-14 lg:max-w-[55vw] xl:max-w-[45vw]'>
        <div className='flex flex-col gap-5'>
            <h1 className='text-5xl lg:text-6xl font-bold ml-1.5'>{info.name}</h1>
            <h1 className='text-3xl lg:text-4xl font-bold -mt-3'>{info.position}</h1>
            <Typewriter
              className="lg:h-[250px]"
              options={{
                strings: info.bio,
                delay: 35,
                cursor: '',
                autoStart: true
              }}
              onInit={(typewriter) => {
                typewriter.start();
              }}
            />
        </div>
        <div className='flex flex-col gap-2'>
          <h1 className='mb-2 text-lg font-semibold'>Main Competencies:</h1>
          <div className='flex items-center flex-wrap gap-4'>
            {info.competencies.map(skill => (
              <img loading='lazy' src={`/storage/${skill.attributes.logo}`} className='h-10 cursor-pointer hover:scale-105 transition-all'
              onMouseEnter={displaySkill()} onMouseLeave={() => setSkill(false)} alt={skill.attributes.title} /> 
            ))}
          </div>
          <div ref={skillName} className={`${skill ? 'w-[200px]' : 'w-0'} transition-all duration-500 overflow-hidden font-semibold text-lg text-[#059669]`}>
              JavaScript
          </div>
        </div>
        <div className='flex flex-col gap-3'>
          <div className='flex flex-col lg:flex-row items-start lg:items-center gap-2 lg:gap-4'>
            <a className='mr-4 relative group dark:hover:bg-white hover:bg-black rounded-full transition-all' href="#" onClick={darkMode()}>
              <img loading='lazy' className="group-hover:opacity-50 h-12 transition-all" src="/storage/jimmy.png" alt="" />
              <img loading='lazy' ref={theme} className='theme-icon opacity-0 group-hover:opacity-100 h-6 absolute top-1/2 left-1/2 transition-all -translate-x-1/2 -translate-y-1/2' src="/storage/sun.svg" alt="theme" />
            </a>
            <div className='flex flex-wrap items-center gap-4'>
              <a className='flex gap-1.5 items-center social-link group transition-all' href={info.linkedin}>LinkedIn <img loading='lazy' className='h-4 group-hover:scale-105 transition-all group-hover:animate-wiggle' src="/storage/linkedin.svg" alt="linkedin"/></a>
              <a className='flex gap-1.5 items-center social-link group transition-all' href={info.github}>GitHub <img loading='lazy' className='h-4 group-hover:scale-105 transition-all group-hover:animate-wiggle' src="/storage/github.svg" alt="github"/></a>
              <a className='flex gap-1.5 items-center social-link group transition-all' href={`mailto:${info.email}`}>Email <img loading='lazy' className='h-4 group-hover:scale-105 transition-all group-hover:animate-wiggle' src="/storage/email.svg" alt="github"/></a>
              <a className='flex gap-1.5 items-center social-link group transition-all' href={`/storage/${info.resume}`}>Resume <img loading='lazy' className='h-4 group-hover:scale-105 transition-all group-hover:animate-wiggle' src="/storage/doc.svg" alt="resume"/></a>
            </div>
          </div>
          <span className='text-sm'>Inspired by <a className='quick-link' target='_blank' href="https://www.sarahdayan.dev/">Sarah Dayan</a> and <a className='quick-link' target='_blank' href="https://dribbble.com/NicolasMzrd">Nicolas Meuzard</a></span>
        </div>
    </div>
  )
}
