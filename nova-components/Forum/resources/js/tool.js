import Tool from './pages/Tool'
import Category from './pages/Category'
import Thread from './pages/Thread'

Nova.booting((app, store) => {
  Nova.inertia('Forum', Tool)
  Nova.inertia('Category', Category)
  Nova.inertia('Thread', Thread)
})
