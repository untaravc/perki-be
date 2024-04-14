import { OhVueIcon, addIcons } from "oh-vue-icons";
import {
  BiArchive,
  BiBezier2,
  BiBookmarkStar,
  BiCameraVideo,
  BiColumnsGap,
  BiCursor,
  BiFilePost,
  BiFileEarmarkPost,
  BiGear,
  BiListCheck,
  BiMenuButtonWide,
  BiNewspaper,
  BiPeople,
  BiSearch,
  BiShieldCheck,
  BiTags,
  BiVectorPen,
} from "oh-vue-icons/icons/bi";

addIcons(
  BiArchive,
  BiBezier2,
  BiBookmarkStar,
  BiCameraVideo,
  BiColumnsGap,
  BiCursor,
  BiFilePost,
  BiFileEarmarkPost,
  BiGear,
  BiListCheck,
  BiMenuButtonWide,
  BiNewspaper,
  BiPeople,
  BiSearch,
  BiShieldCheck,
  BiTags,
  BiVectorPen,
);

// register components
const registerIcon = (app) => {
  app.component('v-icon', OhVueIcon);
}

export default registerIcon