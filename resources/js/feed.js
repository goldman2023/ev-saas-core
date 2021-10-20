// require('./bootstrap')
import React from 'react'
import ReactDOM from 'react-dom'
import ReactRenderer from './feed/ReactRenderer'

import MySimpleComponent from './components/MySimpleComponent'
import FeedComponent from './components/FeedComponent'

const components = [
  {
    name: "MySimpleComponent",
    component: <MySimpleComponent />,
  },
  {
    name: "FeedComponent",
    component: <FeedComponent />,
  },
]



// ReactDOM.render(<MySimpleComponent />, document.getElementById('MySimpleComponent'))
ReactDOM.render(<FeedComponent />, document.getElementById('FeedComponent'))

// new ReactRenderer(components).renderAll()
