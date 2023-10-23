import { $, element } from "../tools.js";

export function Indexs({ wordsState }) {
  const $indexContainer = element("div");

  const $indexs = [];
  for (let i = 1; i <= 10; i++) {
    const $index = element("div");
    $index.classList.add("index");

    $indexs.push($index);
  }

  $indexs.forEach((x, i) => {
    if (wordsState[i]) {
      const userTranslatioIsCorrect =
        wordsState[i]["user-translation-is-correct"];
      x.classList.add(userTranslatioIsCorrect ? "index-pass" : "index-error");
    }
  });

  $indexContainer.setAttribute("id", "index-container");

  $indexs.forEach((e) => {
    $indexContainer.appendChild(e);
  });

  return $indexContainer;
}
