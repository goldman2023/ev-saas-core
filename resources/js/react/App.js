import React from 'react';
import { StreamApp, NotificationDropdown, SinglePost, FlatFeed, LikeButton, Activity, CommentField, CommentList } from 'react-activity-feed';
import 'react-activity-feed/dist/index.css';

class App extends React.Component {
  render() {
    return (
      <StreamApp apiKey='9j8mussvhwku' appId='111762' token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoibW9ybmluZy1kaXNrLTEifQ.lIxj1BnkRA6REdXUdQ8k3E-5shjR4eyQrOQNDMNy4g0'>
        <FlatFeed
          options={{ reactions: { recent: true } }}
          notify
          feedGroup='user'
          userId='eim'
          Activity={(props) => (
            <Activity
              {...props}
              Footer={() => (
                <div style={{ padding: '8px 16px' }}>
                  <LikeButton {...props} />
                  <CommentField activity={props.activity} onAddReaction={props.onAddReaction} />
                </div>
              )}
            />
          )}
        />
      </StreamApp>
    );
  }
}
export default App;